/* Moroccan Hotel Templates - interactive behavior */
const LBHOTEL_HOTELS = [
  {
    id: 'riad-fes',
    name: 'Riad Fès Medina Luxury',
    slug: 'riad-fes',
    city: 'Fès',
    region: 'Fès-Meknès',
    country: 'Morocco',
    postal_code: '30000',
    coords: [34.0649, -4.9734],
    star_rating: 5,
    rooms_total: 42,
    checkin_time: '14:00',
    checkout_time: '12:00',
    avg_price_per_night: 245,
    distance_km: 5,
    date_added: '2023-10-20',
    featured_image: 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=900&q=80',
    gallery: [
      'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=900&q=80',
      'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=900&q=80',
      'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=900&q=80'
    ],
    booking_url: 'https://example.com/booking/riad-fes'
  },
  {
    id: 'la-mamounia',
    name: 'La Mamounia Palace',
    slug: 'la-mamounia',
    city: 'Marrakech',
    region: 'Marrakech-Safi',
    country: 'Morocco',
    postal_code: '40000',
    coords: [31.6206, -7.9936],
    star_rating: 5,
    rooms_total: 210,
    checkin_time: '15:00',
    checkout_time: '12:00',
    avg_price_per_night: 520,
    distance_km: 12,
    date_added: '2023-11-08',
    featured_image: 'https://images.unsplash.com/photo-1501117716987-c8e1ecb2103c?auto=format&fit=crop&w=900&q=80',
    gallery: [
      'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=900&q=80',
      'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?auto=format&fit=crop&w=900&q=80',
      'https://images.unsplash.com/photo-1615486364033-9f35bb26ca7f?auto=format&fit=crop&w=900&q=80'
    ],
    booking_url: 'https://example.com/booking/la-mamounia'
  },
  {
    id: 'sahara-dunes-camp',
    name: 'Sahara Dunes Luxury Camp',
    slug: 'sahara-dunes-camp',
    city: 'Merzouga',
    region: 'Drâa-Tafilalet',
    country: 'Morocco',
    postal_code: '52202',
    coords: [31.0994, -4.0117],
    star_rating: 4,
    rooms_total: 28,
    checkin_time: '13:00',
    checkout_time: '11:00',
    avg_price_per_night: 180,
    distance_km: 48,
    date_added: '2024-01-12',
    featured_image: 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=80',
    gallery: [
      'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=900&q=80',
      'https://images.unsplash.com/photo-1528909514045-2fa4ac7a08ba?auto=format&fit=crop&w=900&q=80',
      'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=80'
    ]
  },
  {
    id: 'essaouira-breeze',
    name: 'Essaouira Breeze Boutique Hotel',
    slug: 'essaouira-breeze',
    city: 'Essaouira',
    region: 'Marrakech-Safi',
    country: 'Morocco',
    postal_code: '44000',
    coords: [31.5085, -9.7595],
    star_rating: 4,
    rooms_total: 64,
    checkin_time: '14:00',
    checkout_time: '11:00',
    avg_price_per_night: 165,
    distance_km: 22,
    date_added: '2024-02-18',
    featured_image: 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=900&q=80',
    gallery: [
      'https://images.unsplash.com/photo-1548588684-23fe9f05f71f?auto=format&fit=crop&w=900&q=80',
      'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=900&q=80',
      'https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=900&q=80'
    ]
  },
  {
    id: 'casablanca-skyline-hotel',
    name: 'Casablanca Skyline Hotel',
    slug: 'casablanca-skyline-hotel',
    city: 'Casablanca',
    region: 'Casablanca-Settat',
    country: 'Morocco',
    postal_code: '20000',
    coords: [33.5731, -7.5898],
    star_rating: 5,
    rooms_total: 320,
    checkin_time: '15:00',
    checkout_time: '12:00',
    avg_price_per_night: 310,
    distance_km: 8,
    date_added: '2024-03-05',
    featured_image: 'https://images.unsplash.com/photo-1505761671935-60b3a7427bad?auto=format&fit=crop&w=900&q=80',
    gallery: [
      'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=900&q=80',
      'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=900&q=80',
      'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=900&q=80'
    ],
    booking_url: 'https://example.com/booking/casablanca-skyline'
  },
  {
    id: 'atlas-mountain-retreat',
    name: 'Atlas Mountain Retreat & Spa',
    slug: 'atlas-mountain-retreat',
    city: 'Imlil',
    region: 'Marrakech-Safi',
    country: 'Morocco',
    postal_code: '42152',
    coords: [31.1355, -7.9181],
    star_rating: 4,
    rooms_total: 52,
    checkin_time: '13:00',
    checkout_time: '11:00',
    avg_price_per_night: 195,
    distance_km: 35,
    date_added: '2024-03-28',
    featured_image: 'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?auto=format&fit=crop&w=900&q=80',
    gallery: [
      'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=80',
      'https://images.unsplash.com/photo-1528909514045-2fa4ac7a08ba?auto=format&fit=crop&w=900&q=80',
      'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=900&q=80'
    ]
  }
];

const LBHOTEL_PAGE_SIZE = 6;

function lbhotelRenderStarRating(rating) {
  return '★'.repeat(rating) + '☆'.repeat(5 - rating);
}

function lbhotelInitLightbox() {
  const overlay = document.createElement('div');
  overlay.className = 'lightbox-overlay';
  overlay.innerHTML = '<img src="" alt="Hotel image preview"><button class="button" style="position:absolute;top:2rem;right:2rem;">Close</button>';
  document.body.appendChild(overlay);

  const img = overlay.querySelector('img');
  const closeButton = overlay.querySelector('button');

  function closeLightbox() {
    overlay.classList.remove('active');
    setTimeout(() => {
      img.src = '';
      img.alt = 'Hotel image preview';
    }, 200);
  }

  overlay.addEventListener('click', (event) => {
    if (event.target === overlay || event.target === closeButton) {
      closeLightbox();
    }
  });

  document.querySelectorAll('[data-lightbox]').forEach((thumb) => {
    thumb.addEventListener('click', () => {
      img.src = thumb.getAttribute('data-lightbox');
      img.alt = thumb.getAttribute('alt') || 'Hotel image';
      overlay.classList.add('active');
    });
  });
}

function lbhotelInitSingleMap() {
  const container = document.getElementById('single-hotel');
  const mapElement = document.getElementById('hotel-map');
  if (!container || !mapElement || typeof L === 'undefined') {
    return;
  }
  const hotelId = container.dataset.hotelId;
  const currentHotel = LBHOTEL_HOTELS.find((hotel) => hotel.id === hotelId) || LBHOTEL_HOTELS[0];

  const map = L.map(mapElement, {
    zoomControl: false,
    scrollWheelZoom: false
  }).setView(currentHotel.coords, 13);

  const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
  }).addTo(map);

  const satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
    attribution: 'Tiles &copy; <a href="https://www.esri.com/">Esri</a>'
  });

  L.control.layers({ 'OpenStreetMap': osm, 'Satellite': satellite }).addTo(map);
  L.control.zoom({ position: 'topright' }).addTo(map);

  LBHOTEL_HOTELS.forEach((hotel) => {
    const marker = L.marker(hotel.coords).addTo(map);
    const rating = lbhotelRenderStarRating(hotel.star_rating);
    marker.bindPopup(`<strong>${hotel.name}</strong><br><span style="color:#c1272d;">${rating}</span>`);
    if (hotel.id === currentHotel.id) {
      marker.openPopup();
    }
  });
}

function lbhotelRenderCards(hotels, page = 1) {
  const listElement = document.getElementById('hotel-cards');
  if (!listElement) {
    return;
  }

  const startIndex = (page - 1) * LBHOTEL_PAGE_SIZE;
  const paginated = hotels.slice(startIndex, startIndex + LBHOTEL_PAGE_SIZE);

  if (paginated.length === 0) {
    listElement.innerHTML = '<p class="placeholder-box">No hotels match your filters just yet. Try adjusting your search.</p>';
    lbhotelRenderPagination(0, 0, []);
    return;
  }

  const cards = paginated.map((hotel) => `
    <article class="hotel-card">
      <img src="${hotel.featured_image}" alt="${hotel.name}">
      <div class="card-body">
        <div class="badge">${hotel.city}, ${hotel.country}</div>
        <h3>${hotel.name}</h3>
        <div class="meta">
          <span>⭐ ${hotel.star_rating}</span>
          <span><strong>${new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(hotel.avg_price_per_night)}</strong>/night</span>
        </div>
      </div>
      <div class="card-footer">
        <a class="button" href="/hotel/${hotel.slug}">View Hotel</a>
      </div>
    </article>
  `);

  listElement.innerHTML = cards.join('');
  const totalPages = Math.ceil(hotels.length / LBHOTEL_PAGE_SIZE);
  lbhotelRenderPagination(page, totalPages, hotels);
}

function lbhotelRenderPagination(currentPage, totalPages, hotels) {
  const pagination = document.querySelector('.pagination');
  if (!pagination) {
    return;
  }
  if (totalPages <= 1) {
    pagination.innerHTML = '';
    return;
  }

  pagination.innerHTML = Array.from({ length: totalPages }, (_, index) => {
    const page = index + 1;
    return `<button type="button" class="${page === currentPage ? 'active' : ''}" data-page="${page}">${page}</button>`;
  }).join('');

  pagination.querySelectorAll('button').forEach((button) => {
    button.addEventListener('click', () => {
      const page = Number(button.dataset.page);
      lbhotelRenderCards(hotels, page);
    });
  });
}

function lbhotelInitListing() {
  const listElement = document.getElementById('hotel-cards');
  const searchInput = document.getElementById('hotel-search');
  const distanceSelect = document.getElementById('hotel-distance');
  const sortSelect = document.getElementById('hotel-sort');

  if (!listElement || !searchInput || !distanceSelect || !sortSelect) {
    return;
  }

  let filtered = [...LBHOTEL_HOTELS];

  const applyFilters = () => {
    const query = searchInput.value.trim().toLowerCase();
    const distance = distanceSelect.value;
    const sort = sortSelect.value;

    filtered = LBHOTEL_HOTELS.filter((hotel) => {
      const matchesQuery = hotel.name.toLowerCase().includes(query) || hotel.city.toLowerCase().includes(query);
      const withinDistance = distance === 'any' || hotel.distance_km <= Number(distance);
      return matchesQuery && withinDistance;
    });

    filtered.sort((a, b) => {
      switch (sort) {
        case 'price':
          return a.avg_price_per_night - b.avg_price_per_night;
        case 'rating':
          return b.star_rating - a.star_rating;
        case 'date':
        default:
          return new Date(b.date_added) - new Date(a.date_added);
      }
    });

    lbhotelRenderCards(filtered, 1);
  };

  searchInput.addEventListener('input', applyFilters);
  distanceSelect.addEventListener('change', applyFilters);
  sortSelect.addEventListener('change', applyFilters);

  applyFilters();
}

function lbhotelInitListingMap() {
  const mapElement = document.getElementById('hotels-map');
  if (!mapElement || typeof L === 'undefined') {
    return;
  }
  const map = L.map(mapElement).setView([31.7917, -7.0926], 5);

  const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
  }).addTo(map);
  const satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
    attribution: 'Tiles &copy; <a href="https://www.esri.com/">Esri</a>'
  });

  L.control.layers({ 'OpenStreetMap': osm, 'Satellite': satellite }).addTo(map);

  LBHOTEL_HOTELS.forEach((hotel) => {
    const marker = L.marker(hotel.coords).addTo(map);
    marker.bindPopup(`<strong>${hotel.name}</strong><br>⭐ ${hotel.star_rating} · ${hotel.city}`);
  });
}

function lbhotelInit() {
  lbhotelInitLightbox();
  lbhotelInitSingleMap();
  lbhotelInitListing();
  lbhotelInitListingMap();
}

document.addEventListener('DOMContentLoaded', lbhotelInit);
