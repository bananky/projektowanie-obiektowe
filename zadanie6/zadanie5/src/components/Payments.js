import React, { useState } from 'react';

const Payments = () => {
  const [formData, setFormData] = useState({
    name: '',
    cardNumber: '',
    expirationDate: '',
    cvv: ''
  });

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    const paymentData = {
      name: formData.name,
      cardNumber: formData.cardNumber,
      expirationDate: formData.expirationDate,
      cvv: formData.cvv
    };
    try {
      const response = await fetch('http://localhost:3000/payments', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(paymentData)
      });
      const responseData = await response.json();
      console.log(responseData);
    } catch (error) {
      console.error('Error:', error);
    }
  };

  return (
    <div>
      <h2>Płatności</h2>
      <form onSubmit={handleSubmit} className="payment-form">
        <div className="form-group">
          <label>
            Imię i nazwisko:
            <input
              type="text"
              name="name"
              value={formData.name}
              onChange={handleChange}
              required
            />
          </label>
        </div>
        <div className="form-group">
          <label>
            Numer karty:
            <input
              type="text"
              name="cardNumber"
              value={formData.cardNumber}
              onChange={handleChange}
              required
            />
          </label>
        </div>
        <div className="form-group">
          <label>
            Data ważności:
            <input
              type="text"
              name="expirationDate"
              value={formData.expirationDate}
              onChange={handleChange}
              required
            />
          </label>
        </div>
        <div className="form-group">
          <label>
            CVV:
            <input
              type="text"
              name="cvv"
              value={formData.cvv}
              onChange={handleChange}
              required
            />
          </label>
        </div>
        <button type="submit">Zapłać</button>
      </form>
    </div>
  );
};

export default Payments;
