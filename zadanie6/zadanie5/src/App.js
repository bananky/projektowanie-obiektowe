import Products from './components/Products';
import Cart from './components/Cart';
import Payments from './components/Payments';
import './App.css';
import React, { useState } from 'react';


function App() {
  const [cart, setCart] = useState([]);

  const addToCart = (product) => {
    setCart([...cart, product]);
  };

  return (
    <div className="App">
      <header className="App-header">
        <h1>Sklep internetowy</h1>
      </header>
      <div className="container">
        <div className="cart-container">
        <Cart cart={cart} setCart={setCart} /> {}
          </div>
        <div className="products-container">
          <Products addToCart={addToCart} />
        </div>
          <div className="payments-container">
            <Payments />
          </div>
        
      </div>
    </div>
  );
}

export default App;