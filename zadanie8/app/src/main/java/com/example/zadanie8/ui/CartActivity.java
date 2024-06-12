// CartActivity.java
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.widget.TextView;

import com.example.zadanie8.R;
import com.example.zadanie8.adapter.CartAdapter;
import com.example.zadanie8.adapter.CartManager;
import com.example.zadanie8.model.Product;

import java.util.List;

public class CartActivity extends AppCompatActivity {

    private RecyclerView recyclerView;
    private CartAdapter cartAdapter;
    private CartManager cartManager;
    private TextView totalPriceTextView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_cart);

        cartManager = new CartManager();

        recyclerView = findViewById(R.id.cartRecyclerView);
        totalPriceTextView = findViewById(R.id.totalPriceTextView);

        recyclerView.setLayoutManager(new LinearLayoutManager(this));
        cartAdapter = new CartAdapter(cartManager.getCartItems());
        recyclerView.setAdapter(cartAdapter);


        updateTotalPrice();


        Product product1 = new Product("1", "Książka", 29.99);
        Product product2 = new Product("2", "Koszulka", 19.99);
        cartManager.addItem(product1, 2);
        cartManager.addItem(product2, 1);

        cartAdapter.notifyDataSetChanged();
        updateTotalPrice();
    }


    private void updateTotalPrice() {
        double totalPrice = cartManager.getTotalPrice();
        totalPriceTextView.setText("Całkowita cena: " + totalPrice + " zł");
    }

