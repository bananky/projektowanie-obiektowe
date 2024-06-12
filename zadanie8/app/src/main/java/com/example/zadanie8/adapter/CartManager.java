package com.example.zadanie8.adapter;


import com.example.zadanie8.model.CartItem;
import com.example.zadanie8.model.Product;

import java.util.ArrayList;
import java.util.List;

public class CartManager {
    private List<CartItem> cartItems;

    public CartManager() {
        cartItems = new ArrayList<>();
    }

    public void addItem(Product product, int quantity) {

        for (CartItem item : cartItems) {
            if (item.getProduct().getId().equals(product.getId())) {
                item.setQuantity(item.getQuantity() + quantity);
                return;
            }
        }
        cartItems.add(new CartItem(product, quantity));
    }

    public void removeItem(CartItem item) {
        cartItems.remove(item);
    }

    public List<CartItem> getCartItems() {
        return cartItems;
    }

    public double getTotalPrice() {
        double total = 0;
        for (CartItem item : cartItems) {
            total += item.getProduct().getPrice() * item.getQuantity();
        }
        return total;
    }
}
