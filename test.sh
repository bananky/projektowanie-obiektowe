#!/bin/bash

BASE_URL="http://localhost:8000"


function testGetAllProducts {
    response=$(curl -s -X GET "${BASE_URL}/produkt")

    expectedData='[{"id":1,"name":"taśma","price":3.99},{"id":2,"name":"klej","price":4.99}]'

    if [ "$response" == "$expectedData" ]; then
        echo "OK testGetAllProducts"
    else
        echo "FAILED testGetAllProducts"
    fi
}

function testGetProductById {
    local id=$1
    response=$(curl -s -X GET "${BASE_URL}/produkt/${id}")

    expectedData='{"id":1,"name":"taśma","price":3.99}'

    if [ "$response" == "$expectedData" ]; then
        echo "OK testGetProductById"
    else
        echo "FAILED testGetProductById"
    fi
}

function testCreateProduct {
    response=$(curl -s -X POST "${BASE_URL}/produkt" \
      -H "Content-Type: application/json" \
      -d '{
        "name": "Produkt",
        "price": 99
      }')

    expectedData='{"message":"Product created successfully"}'

    if [ "$response" == "$expectedData" ]; then
        echo "OK testCreateProduct"
    else
        echo "FAILED testCreateProduct"
    fi
}

function testUpdateProduct {
    local id=$1

    response=$(curl -s -X PUT "${BASE_URL}/produkt/${id}" \
      -H "Content-Type: application/json" \
      -d '{
        "name": "Produkt",
        "price": 999
      }')

    expectedData='{"message":"Product updated successfully"}'

    if [ "$response" == "$expectedData" ]; then
        echo "OK testUpdateProduct"
    else
        echo "FAILED testUpdateProduct"
    fi
}

function testDeleteProduct {
    local id=$1

    response=$(curl -s -X DELETE "${BASE_URL}/produkt/${id}")

    expectedData='{"message":"Product deleted successfully"}'

    if [ "$response" == "$expectedData" ]; then
        echo "OK testDeleteProduct"
    else
        echo "FAILED testDeleteProduct"
    fi
}

testGetAllProducts
testGetProductById 1
testCreateProduct
testUpdateProduct 1
testDeleteProduct 1