
package com.example.zadanie8.ui;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;

import androidx.appcompat.app.AppCompatActivity;

import com.example.zadanie8.R;
import com.example.zadanie8.adapter.CategoryAdapter;
import com.example.zadanie8.model.Category;

import java.util.ArrayList;
import java.util.List;

public class CategoryListActivity extends AppCompatActivity {

    private ListView listView;
    private List<Category> categoryList;
    private CategoryAdapter categoryAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_category_list);

        listView = findViewById(R.id.category_list_view);
        categoryList = getCategories();
        categoryAdapter = new CategoryAdapter(this, categoryList);
        listView.setAdapter(categoryAdapter);

        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Category selectedCategory = categoryList.get(position);
                Intent intent = new Intent(CategoryListActivity.this, ProductListActivity.class);
                intent.putExtra("categoryId", selectedCategory.getId());
                startActivity(intent);
            }
        });
    }

    private List<Category> getCategories() {
        List<Category> categories = new ArrayList<>();
        categories.add(new Category("1", "Electronics"));
        categories.add(new Category("2", "Books"));
        categories.add(new Category("3", "Clothing"));
        return categories;
    }
}
