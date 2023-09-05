## Looi Challenge Backend

Simple Laravel API - Breeze was used for authorization using Sanctum API TOKENS.
FE is in another repository. I could have done it in one repository as recommended, in that case I would have picked SPA Session Auth from Sanctum instead of API Tokens.

# Installation

-   Rename .env.example to .env , configure your DB settings
-   run: Artisan migrate
-   run: Artisan db:seed

You will have 2 users created :

user1@fake.com / passw: 1234
user2@fake.com / passw: 1234

# Routes

-   POST /api/signup
-   POST /api/login
-   GET /api/
-   POST /api/
-   GET /api/{id}
-   DELETE /api/{id}
-   PUT /api/{id}
