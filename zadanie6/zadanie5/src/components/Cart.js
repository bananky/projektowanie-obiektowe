import React from 'react';
import PropTypes from 'prop-types';

const Cart = ({ cart, setCart }) => {
  const removeFromCart = (productId) => {
    setCart((prevCart) => prevCart.filter(item => item.id !== productId));
  };

  return (
    <div>
      <h2>Koszyk</h2>
      <ul className="cart-list">
        {cart.map(item => (
          <li key={item.id} className="cart-item">
            {/* Display product name and price */}
            {item.name} - {item.price} zł
            <button onClick={() => removeFromCart(item.id)}>Usuń</button>
          </li>
        ))}
      </ul>
    </div>
  );
};

Cart.propTypes = {
  cart: PropTypes.arrayOf(PropTypes.shape({
    id: PropTypes.number.isRequired,
    name: PropTypes.string.isRequired,
    price: PropTypes.number.isRequired,
  })).isRequired,
  setCart: PropTypes.func.isRequired,
};

export default Cart;
