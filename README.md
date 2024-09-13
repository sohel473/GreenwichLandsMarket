# Greenwich Landmark Pictures Selling Website

This project is an e-commerce platform designed for selling pictures of popular landmarks within the Old Royal Naval College. It is built with Laravel and incorporates User-Centered Design (UCD) principles to accommodate users from different age groups and physical profiles, including senior citizens with various health and social challenges. The platform enables a smooth and accessible user experience for all, with full CRUD functionality for both administrators and users.

### Note that this project was created for a university coursework and is not intended for commercial use.

## Coursework PDF

The coursework for this project can be found (Public/CourseWork_COMP1678_001287370.pdf) [here](http://localhost:8000/coursework.pdf).


## Features

### User Management

-   **Registration and Login**: Users can register, log in, and manage their accounts.
-   **Persistent Login**: Session tokens ensure that users remain logged in.
-   **User Profiles**: Users can manage their profiles, including personal information (name, birth date, contact details, address).
-   **Admin User Management**: Admins can create, view, update, and delete user profiles.

### Product Management

-   **Product Listings**: Admins can create, update, and delete products (landmark pictures).
-   **Picture Categories**: Users can browse different categories of landmark pictures.
-   **Detailed Product View**: Each product (picture) includes details such as description, price, and availability.

### Shopping Cart & Orders

-   **Cart Functionality**: Users can add pictures to the cart, adjust quantities, and remove items before purchase.
-   **Checkout Process**: Once ready, users can complete the checkout process, and their orders will be linked to their account.
-   **Order Management**: Admins can manage orders, view payment statuses, and track orders with payment and order IDs.

### Accessibility and UCD

-   **User-Centered Design**: The website is built to be accessible to all age groups and users with physical or social challenges. Special consideration is given to making the interface user-friendly for senior citizens.
-   **Responsive Design**: The website is mobile-friendly and can adapt to different screen sizes.

### Content Management System (CMS)

-   **Admin Dashboard**: Admins can access a dashboard for managing users, products, and orders.
-   **CRUD Operations**: Full CRUD capabilities for products, users, and orders, allowing for seamless management of the online store.

## Installation

To set up the project locally, follow these steps:

### Prerequisites

-   PHP 8.x
-   Composer
-   MySQL or any other database supported by Laravel
-   Node.js & NPM

### Steps

1. **Clone the repository**

    ```bash
    git clone https://github.com/yourusername/landmark-pictures-ecommerce.git
    cd landmark-pictures-ecommerce
    ```

2. **Install dependencies**

    ```bash
    composer install
    npm install
    ```

3. **Create a new database**

    ```bash
    mysql -u root -p
    CREATE DATABASE landmark_pictures;
    ```

4. **Configure the database**

    ```bash
    php artisan migrate
    php artisan db:seed
    ```

5. **Start the development server**

    ```bash
    php artisan serve
    ```

6. **Access the website**
   Open your browser and navigate to `http://localhost:8000`.

