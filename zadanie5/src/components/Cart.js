import React from 'react';

const Cart = ({ cart, setCart }) => {
  const removeFromCart = (productId) => {
    setCart(cart.filter(item => item.id !== productId));
  };

  return (
    <div>
      <h2>Koszyk</h2>
      <ul className="cart-list">
        {cart.map(item => (
          <li key={item.id} className="cart-item">
            {item.name} - {item.price} zł
            <button onClick={() => removeFromCart(item.id)}>Usuń</button>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default Cart;