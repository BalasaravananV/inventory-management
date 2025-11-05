<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Inventory Dashboard</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    * { box-sizing: border-box; font-family: 'Poppins', sans-serif; }
    body { margin: 0; display: flex; height: 100vh; background: #f4f6f8; }

    .sidebar {
      width: 220px; background: #2c3e50; color: white;
      display: flex; flex-direction: column; padding-top: 20px;
    }

    .sidebar h2 { text-align: center; margin-bottom: 30px; }
    .menu a { display: block; padding: 12px 20px; color: #ecf0f1; text-decoration: none; }
    .menu a:hover, .menu a.active { background: #4ca1af; }

    .content {
      flex: 1; padding: 30px; background: #fff; border-radius: 12px;
      margin: 30px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      overflow-y: auto;
    }

    h1 { color: #333; margin-bottom: 20px; }
    label { display: block; margin: 10px 0 5px; }
    input { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc; }

    button {
      background: #4ca1af; color: #fff; border: none;
      padding: 10px; border-radius: 6px; width: 100%;
      margin-top: 15px; cursor: pointer;
    }
    button:hover { background: #357f8a; }

    .success-msg {
      background: #d4edda;
      color: #155724;
      padding: 10px;
      border-radius: 6px;
      margin-top: 10px;
      text-align: center;
    }
    .error-msg {
      background: #f8d7da;
      color: #721c24;
      padding: 10px;
      border-radius: 6px;
      margin-top: 10px;
      text-align: center;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Inventory</h2>
    <div class="menu">
      <a href="#products" id="menuProducts" class="active">Products</a>
      <a href="#warehouses" id="menuWarehouses">Warehouses</a>
    </div>
  </div>

  <!-- Main Content -->
  <div class="content" id="contentArea"></div>

  <script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const contentArea = document.getElementById('contentArea');
    const menuProducts = document.getElementById('menuProducts');
    const menuWarehouses = document.getElementById('menuWarehouses');

    // Product Form
    const productsPage = `
      <div id="productsPage">
        <h1>Add Product</h1>
        <form id="productForm">
          <label for="pr_name">Product Name</label>
          <input type="text" id="pr_name" name="pr_name" required>

          <label for="base_price">Product Price</label>
          <input type="number" id="base_price" name="base_price" required>

          <button type="submit">Save Product</button>
        </form>
        <div id="productMsg"></div>
      </div>
    `;

    // Warehouse Form
    const warehousePage = `
      <div id="warehousePage">
        <h1>Add Warehouse</h1>
        <form id="warehouseForm">
          <label for="wh_name">Warehouse Name</label>
          <input type="text" id="wh_name" name="name" required>

          <label for="latitude">Latitude (-90 to 90)</label>
          <input type="text" id="latitude" name="latitude" required>

          <label for="longitude">Longitude (-180 to 180)</label>
          <input type="text" id="longitude" name="longitude" required>

          <button type="submit">Save Warehouse</button>
        </form>
        <div id="warehouseMsg"></div>
      </div>
    `;

    // Function to load page content
    function showPage(page) {
      if (page === 'products') {
        contentArea.innerHTML = productsPage;
        menuProducts.classList.add('active');
        menuWarehouses.classList.remove('active');
        window.history.pushState({}, '', '#products');
        setupProductForm();
      } else {
        contentArea.innerHTML = warehousePage;
        menuWarehouses.classList.add('active');
        menuProducts.classList.remove('active');
        window.history.pushState({}, '', '#warehouses');
        setupWarehouseForm();
      }
    }

    // AJAX for Product
    function setupProductForm() {
      const form = document.getElementById('productForm');
      form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const data = new FormData(form);
        const response = await fetch("{{ route('products.store') }}", {
          method: "POST",
          headers: { "X-CSRF-TOKEN": csrfToken },
          body: data
        });
        const result = await response.json();
        document.getElementById('productMsg').innerHTML =
          `<div class="success-msg">${result.message || 'Product saved!'}</div>`;
        form.reset();
      });
    }

    // AJAX for Warehouse
    function setupWarehouseForm() {
      const form = document.getElementById('warehouseForm');
      form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const data = new FormData(form);
        try {
          const response = await fetch("{{ route('warehouses.store') }}", {
            method: "POST",
            headers: { "X-CSRF-TOKEN": csrfToken },
            body: data
          });
          if (!response.ok) throw new Error('Network response was not OK');
          const result = await response.json();
          document.getElementById('warehouseMsg').innerHTML =
            `<div class="success-msg">${result.message || 'Warehouse saved!'}</div>`;
          form.reset();
        } catch (error) {
          document.getElementById('warehouseMsg').innerHTML =
            `<div class="error-msg">Error: ${error.message}</div>`;
        }
      });
    }

    // Initial page load
    window.addEventListener('load', () => {
      const hash = window.location.hash.replace('#', '');
      if (hash === 'warehouses') showPage('warehouses');
      else showPage('products');
    });

    // Menu click events
    menuProducts.addEventListener('click', (e) => {
      e.preventDefault();
      showPage('products');
    });
    menuWarehouses.addEventListener('click', (e) => {
      e.preventDefault();
      showPage('warehouses');
    });
  </script>

</body>
</html>
