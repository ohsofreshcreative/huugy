import { initializePriceFilters } from './price-filter.js';

const terms = (url, key) => new Set((url.searchParams.get(key) || '').split(',').filter(Boolean));

function attributeChange(current, target) {
  const keys = new Set([...current.searchParams.keys(), ...target.searchParams.keys()]);
  for (const key of keys) {
    if (!key.startsWith('filter_')) continue;
    const before = terms(current, key);
    const after = terms(target, key);
    const changed = [...new Set([...before, ...after])].filter((term) => before.has(term) !== after.has(term));
    if (changed.length === 1) {
      const queryKey = key.replace('filter_', 'query_type_');
      return { key, term: changed[0], target, queryType: target.searchParams.get(queryKey) || current.searchParams.get(queryKey) };
    }
  }
  return null;
}

function toggleAttribute(current, { key, term, target, queryType }) {
  const url = new URL(current);
  url.pathname = target.pathname;
  url.searchParams.delete('paged');
  url.searchParams.delete('product-page');
  const selected = terms(url, key);
  const queryKey = key.replace('filter_', 'query_type_');
  if (selected.has(term)) selected.delete(term);
  else selected.add(term);

  if (selected.size) {
    url.searchParams.set(key, [...selected].sort().join(','));
    if (queryType) url.searchParams.set(queryKey, queryType);
  } else {
    url.searchParams.delete(key);
    url.searchParams.delete(queryKey);
  }
  return url;
}

const catalog = document.querySelector('[data-shop-catalog]');

if (catalog) {
  const products = catalog.querySelector('.__products');
  const sidebar = catalog.querySelector('.__shop-sidebar');
  const status = catalog.querySelector('[data-shop-status]');
  let renderedURL = new URL(window.location.href);
  let desiredURL = new URL(renderedURL);
  let attributeLinks = new Map();
  let timer;
  let inFlight = false;
  let pending = false;
  let version = 0;
  let updateHistory = true;
  let pagination = false;

  const syncSelections = () => {
    attributeLinks.forEach((change, link) => {
      const selected = terms(desiredURL, change.key).has(change.term);
      link.closest('li').classList.toggle('chosen', selected);
      link.closest('li').classList.toggle('woocommerce-widget-layered-nav-list__item--chosen', selected);
      link.setAttribute('aria-label', `${selected ? 'Usuń' : 'Dodaj'} filtr: ${link.textContent.trim()}`);
      link.href = toggleAttribute(desiredURL, change).href;
    });
  };

  const initialize = () => {
    attributeLinks = new Map();
    catalog.querySelectorAll('.woocommerce-widget-layered-nav-list a').forEach((link) => {
      const change = attributeChange(renderedURL, new URL(link.href));
      if (change) attributeLinks.set(link, change);
    });
    syncSelections();
  };

  const setLoading = (loading) => {
    catalog.toggleAttribute('data-loading', loading);
    products.setAttribute('aria-busy', String(loading));
    if (loading) status.textContent = 'Aktualizowanie produktów…';
  };

  const load = async () => {
    if (inFlight || !pending) return;
    pending = false;
    if (desiredURL.href === renderedURL.href) {
      setLoading(false);
      status.textContent = 'Lista produktów jest aktualna.';
      return;
    }

    inFlight = true;
    const requestVersion = version;
    const url = new URL(desiredURL);
    const controller = new AbortController();
    const timeout = setTimeout(() => controller.abort(), 15000);

    try {
      // Pobieramy standardowy widok, aby zachować zapytania i reguły filtrów WooCommerce.
      const response = await fetch(url, { signal: controller.signal, credentials: 'same-origin' });
      if (!response.ok || new URL(response.url).origin !== window.location.origin) throw new Error('Invalid shop response');
      const html = await response.text();
      if (requestVersion !== version) return;
      const page = new DOMParser().parseFromString(html, 'text/html');
      const nextCatalog = page.querySelector('[data-shop-catalog]');
      const nextProducts = nextCatalog?.querySelector('.__products');
      const nextSidebar = nextCatalog?.querySelector('.__shop-sidebar');
      if (!nextProducts || (sidebar && !nextSidebar)) throw new Error('Missing shop content');

      const active = document.activeElement;
      const focusedAttribute = attributeLinks.get(active);
      const focusedInput = sidebar?.contains(active) && active.matches('input') ? active.name : null;
      const focusResults = products.contains(active) || sidebar?.contains(active);
      const $ = window.jQuery;
      if ($?.fn.slider) $(sidebar).find('.price_slider.ui-slider').slider('destroy');

      // Skrypty strony nie są ponownie wykonywane po podmianie fragmentów.
      nextCatalog.querySelectorAll('script').forEach((script) => script.remove());
      if (sidebar) sidebar.replaceChildren(...nextSidebar.childNodes);
      products.replaceChildren(...nextProducts.childNodes);
      renderedURL = new URL(response.url);
      desiredURL = new URL(renderedURL);
      if (updateHistory && window.location.href !== renderedURL.href) {
        window.history.pushState(null, '', renderedURL.href);
      }
      document.title = page.title;
      if ($?.fn.slider) $(document.body).trigger('init_price_filter');
      initializePriceFilters(catalog);
      initialize();
      window.ScrollTrigger?.refresh();

      if (focusResults) {
        const attribute = [...attributeLinks].find(([, change]) => change.key === focusedAttribute?.key && change.term === focusedAttribute?.term)?.[0];
        const input = focusedInput ? [...sidebar.querySelectorAll('input')].find((item) => item.name === focusedInput) : null;
        products.setAttribute('tabindex', '-1');
        (attribute || input || products).focus({ preventScroll: true });
      }
      if (pagination) products.scrollIntoView({ block: 'start' });
      setLoading(false);
      const count = products.querySelectorAll('.products > li').length;
      status.textContent = count ? `Zaktualizowano listę. Liczba widocznych produktów: ${count}.` : 'Brak produktów spełniających wybrane kryteria.';
    } catch (error) {
      if (requestVersion === version) window.location.assign(desiredURL.href);
    } finally {
      clearTimeout(timeout);
      inFlight = false;
      // Kolejne żądanie rusza dopiero po poprzednim; starsza odpowiedź nie zmienia widoku.
      if (pending && !timer) load();
    }
  };

  const navigate = (url, { history = true, page = false } = {}) => {
    desiredURL = url;
    updateHistory = history;
    pagination = page;
    version += 1;
    pending = true;
    clearTimeout(timer);
    syncSelections();
    setLoading(true);
    timer = setTimeout(() => {
      timer = null;
      load();
    }, 300);
  };

  catalog.addEventListener('click', (event) => {
    if (event.defaultPrevented || event.button !== 0 || event.ctrlKey || event.metaKey || event.shiftKey || event.altKey) return;
    const link = event.target.closest('a');
    if (!link || link.hasAttribute('download') || (link.target && link.target !== '_self')) return;
    const target = new URL(link.href);
    if (target.origin !== window.location.origin) return;

    if (attributeLinks.has(link)) {
      event.preventDefault();
      navigate(toggleAttribute(desiredURL, attributeLinks.get(link)));
    } else if (link.closest('.widget_layered_nav_filters')) {
      event.preventDefault();
      const url = new URL(desiredURL);
      url.pathname = target.pathname;
      const keys = new Set([...renderedURL.searchParams.keys(), ...target.searchParams.keys()]);
      keys.forEach((key) => {
        if (renderedURL.searchParams.get(key) === target.searchParams.get(key)) return;
        if (key.startsWith('filter_')) {
          const selected = terms(url, key);
          const remaining = terms(target, key);
          terms(renderedURL, key).forEach((term) => { if (!remaining.has(term)) selected.delete(term); });
          if (selected.size) url.searchParams.set(key, [...selected].sort().join(','));
          else {
            url.searchParams.delete(key);
            url.searchParams.delete(key.replace('filter_', 'query_type_'));
          }
        } else if (target.searchParams.has(key)) url.searchParams.set(key, target.searchParams.get(key));
        else url.searchParams.delete(key);
      });
      url.searchParams.delete('paged');
      url.searchParams.delete('product-page');
      navigate(url);
    } else if (link.closest('.woocommerce-pagination')) {
      event.preventDefault();
      const url = new URL(desiredURL);
      url.pathname = target.pathname;
      ['paged', 'product-page'].forEach((key) => {
        if (target.searchParams.has(key)) url.searchParams.set(key, target.searchParams.get(key));
        else url.searchParams.delete(key);
      });
      navigate(url, { page: true });
    }
  });

  catalog.addEventListener('submit', (event) => {
    const form = event.target;
    if (!form.closest('.widget_price_filter')) return;
    const action = new URL(form.action);
    if (action.origin !== window.location.origin) return;
    event.preventDefault();
    form.querySelectorAll('[name="min_price"], [name="max_price"]').forEach((input) => input.dispatchEvent(new Event('change')));
    const data = new FormData(form);
    const url = new URL(desiredURL);
    url.pathname = action.pathname;
    ['min_price', 'max_price'].forEach((key) => {
      const value = data.get(key);
      if (value !== null && value !== '') url.searchParams.set(key, value);
      else url.searchParams.delete(key);
    });
    url.searchParams.delete('paged');
    url.searchParams.delete('product-page');
    navigate(url);
  });

  window.addEventListener('popstate', () => navigate(new URL(window.location.href), { history: false }));
  initialize();
}
