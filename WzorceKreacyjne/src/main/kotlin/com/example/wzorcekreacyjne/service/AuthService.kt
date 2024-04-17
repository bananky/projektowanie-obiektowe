package com.example.wzorcekreacyjne.service

object AuthService {
    private val userCredentials = mapOf(
        "admin" to "admin123",
        "user" to "user123"
    )

    fun authenticate(username: String, password: String): Boolean {
        if (!userCredentials.containsKey(username)) {
            return false
        }

        val expectedPassword = userCredentials[username]
        return expectedPassword == password
    }
}
