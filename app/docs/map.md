web-store/
│── public/                 # Static assets (favicon, robots.txt, etc.)
│── src/
│   ├── assets/             # Global styles, images, and static assets
│   │   ├── styles/         # Global Tailwind styles
│   │   ├── images/         # Store images (logos, banners, etc.)
│   │   └── icons/          # SVG icons
│   ├── components/         # Reusable UI components
│   │   ├── navbar/         # Navigation components
│   │   ├── footer/         # Footer components
│   │   ├── product/        # Product-related components
│   │   ├── ui/             # Small reusable UI elements (buttons, modals, etc.)
│   │   └── dashboard/      # Dashboard-specific components
│   ├── layouts/            # Page layouts (default, admin, auth)
│   ├── pages/              # Main views/pages
│   │   ├── home/           # Home page
│   │   ├── shop/           # Shop and product pages
│   │   ├── cart/           # Shopping cart page
│   │   ├── checkout/       # Checkout page
│   │   ├── account/        # User profile and orders
│   │   ├── auth/           # Login/Register pages
│   │   └── admin/          # Admin panel (dashboard, products, orders)
│   ├── router/             # Vue Router configuration
│   │   ├── index.js        # Main router setup
│   │   ├── auth.js         # Authentication routes
│   │   ├── admin.js        # Admin panel routes
│   │   └── shop.js         # Store-related routes
│   ├── store/              # Pinia state management
│   │   ├── authStore.js    # Authentication state
│   │   ├── productStore.js # Product-related state
│   │   ├── cartStore.js    # Shopping cart state
│   │   ├── orderStore.js   # Order state
│   │   └── uiStore.js      # UI state (sidebar, modals, etc.)
│   ├── services/           # API requests & business logic
│   │   ├── authService.js  # Auth API calls
│   │   ├── productService.js # Product-related API calls
│   │   ├── cartService.js  # Cart API calls
│   │   ├── orderService.js # Order API calls
│   │   └── paymentService.js # Payment API calls
│   ├── composables/        # Vue 3 Composition API functions
│   ├── directives/         # Custom Vue directives
│   ├── utils/              # Helper functions (formatting, validation, etc.)
│   ├── App.vue             # Root Vue component
│   ├── main.js             # Vue entry point
│── .env                    # Environment variables
│── tailwind.config.js      # Tailwind CSS config
│── vite.config.js          # Vite config
│── package.json            # Project dependencies
│── README.md               # Project documentation
