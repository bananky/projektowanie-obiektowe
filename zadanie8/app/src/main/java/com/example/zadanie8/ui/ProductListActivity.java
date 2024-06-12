// app/src/main/java/[nazwa_pakietu]/ui/ProductListActivity.java
package com.example.zadanie8.ui;

import android.os.Bundle;
import android.widget.ListView;

import androidx.appcompat.app.AppCompatActivity;

import com.example.zadanie8.R;
import com.example.zadanie8.adapter.ProductAdapter;
import com.example.zadanie8.model.Product;

import java.util.ArrayList;
import java.util.List;

public class ProductListActivity extends AppCompatActivity {

    private ListView listView;
    private List<Product> productList;
    private ProductAdapter productAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_product_list);

        listView = findViewById(R.id.product_list_view);

        String categoryId = getIntent().getStringExtra("categoryId");
        productList = getProductsByCategory(categoryId);
        productAdapter = new ProductAdapter(this, productList);
        listView.setAdapter(productAdapter);
    }

    private List<Product> getProductsByCategory(String categoryId) {
        List<Product> products = new ArrayList<>();
        if (categoryId.equals("1")) {
            products.add(new Product("1", "Smartphone", "1", 699.99));
            products.add(new Product("2", "Laptop", "1", 1299.99));
        } else if (categoryId.equals("2")) {
            products.add(new Product("3", "Fiction Book", "2", 19.99));
            products.add(new Product("4", "Non-Fiction Book", "2", 29.99));
        } else if (categoryId.equals("3")) {
            products.add(new Product("5", "T-Shirt", "3", 9.99));
            products.add(new Product("6", "Jeans", "3", 49.99));
        }
        return products;
    }
}
