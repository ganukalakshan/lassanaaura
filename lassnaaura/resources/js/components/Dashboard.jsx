import React from 'react';

const demoProducts = [
  { id: 1, name: 'Blush Glow Palette', price: '$24', desc: 'A silky matte + shimmer palette for any look.', img: '/images/1.webp' },
  { id: 2, name: 'Rose Radiance Serum', price: '$35', desc: 'Lightweight serum for glowing skin.', img: '/images/2.png' },
  { id: 3, name: 'Velvet Lipstick', price: '$18', desc: 'Long-lasting color with creamy finish.', img: '/images/3.jpg' },
  { id: 4, name: 'Silk Foundation', price: '$29', desc: 'Buildable coverage, natural finish.', img: '/images/4.jpg' },
];

export default function Dashboard() {
  return (
    <div className="dashboard-page">
      <header className="dash-header">
        <h1>Dashboard</h1>
        <p className="lead">Welcome back — here are some featured products.</p>
      </header>

      <main className="cards-grid">
        {demoProducts.map((p) => (
          <article className="product-card" key={p.id}>
            <div className="product-media" aria-hidden>
              <img src={p.img} alt={p.name} className="product-image" />
            </div>
            <div className="product-body">
              <h3 className="product-title">{p.name}</h3>
              <p className="product-desc">{p.desc}</p>
              <div className="product-meta">
                <span className="price">{p.price}</span>
                <button className="btn">View</button>
              </div>
            </div>
          </article>
        ))}
      </main>
    </div>
  );
}
