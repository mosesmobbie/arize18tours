import './bootstrap';
import './booking';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const fleetGrid = document.getElementById('fleetGrid');
const fleetPrev = document.getElementById('fleetPrev');
const fleetNext = document.getElementById('fleetNext');

function getFleetStep() {
  if (!fleetGrid) return 0;
  const card = fleetGrid.querySelector('.fleet-card');
  if (!card) return fleetGrid.clientWidth;
  const style = window.getComputedStyle(fleetGrid);
  const gap = parseFloat(style.columnGap || style.gap || '0') || 0;
  return card.clientWidth + gap;
}

if (fleetGrid && fleetPrev && fleetNext) {
  fleetPrev.addEventListener('click', () => {
    fleetGrid.scrollBy({ left: -getFleetStep(), behavior: 'smooth' });
  });

  fleetNext.addEventListener('click', () => {
    fleetGrid.scrollBy({ left: getFleetStep(), behavior: 'smooth' });
  });
}

const mobileNavToggle = document.getElementById('mobileNavToggle');
const primaryNav = document.getElementById('primaryNav');

if (mobileNavToggle && primaryNav) {
  mobileNavToggle.addEventListener('click', () => {
    const isOpen = primaryNav.classList.toggle('is-open');
    mobileNavToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  });

  primaryNav.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => {
      primaryNav.classList.remove('is-open');
      mobileNavToggle.setAttribute('aria-expanded', 'false');
    });
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth > 900) {
      primaryNav.classList.remove('is-open');
      mobileNavToggle.setAttribute('aria-expanded', 'false');
    }
  });
}
