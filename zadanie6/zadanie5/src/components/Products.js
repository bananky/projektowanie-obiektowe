import React, { useState, useEffect } from 'react';
import PropTypes from 'prop-types';

const Products = ({ addToCart }) => {
  const [products, setProducts] = useState([]);

  useEffect(() => {
    fetchProducts();
  }, []);

  const fetchProducts = async () => {
    try {
      const response = await fetch('http://localhost:3000/products');
      if (!response.ok) {
        throw new Error('Failed to fetch products');
      }
      const data = await response.json();
      setProducts(data);
    } catch (error) {
      console.error(error);
    }
  };

  const handleAddToCart = (product) => {
    addToCart(product);
  };

  return (
    <div>
      <h2>Lista Produktów</h2>
      <ul className="product-list">
        {products.map(product => (
          <li key={product.id} className="product-item">
            {product.name} - {product.price} zł
            <button onClick={() => handleAddToCart(product)}>Dodaj do koszyka</button>
          </li>
        ))}
      </ul>
    </div>
  );
};

Products.propTypes = {
  addToCart: PropTypes.func.isRequired,
};

export default Products;
