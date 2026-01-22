<?php
// =========================================================================
// iMARKET ADMIN PORTAL - Main Application File
//
// NOTE: This file is a monolithic structure combining connection, functions,
// and presentation for simplicity in a single-file environment.
// =========================================================================

// =========================================================================
// 1. DATABASE CONNECTION CONFIGURATION
// =========================================================================
// Include the centralized database connection file
require_once 'connection.php';

// Get the database connection
try {
    $pdo = get_db_connection();
} catch (RuntimeException $e) {
    http_response_code(500);
    $safeMessage = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    $supportTips = [
        'Ensure that the MySQL server is running.',
        'Double-check the credentials in connection.php or your environment variables.',
        'Confirm that the correct port is open (defaults attempted: ' . htmlspecialchars(implode(', ', array_unique(array_filter([
            getenv('DB_PORT') !== false ? getenv('DB_PORT') : '3306',
            getenv('DB_FALLBACK_PORT') !== false ? getenv('DB_FALLBACK_PORT') : null,
            '3306',
        ]))), ENT_QUOTES, 'UTF-8') . ').',
    ];
    echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>System Configuration Error</title>
    <style>
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #0f172a; color: #e2e8f0; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .error-card { background: #111827; padding: 2.5rem; border-radius: 1rem; max-width: 520px; box-shadow: 0 25px 50px -12px rgba(30, 64, 175, 0.45); border: 1px solid rgba(59, 130, 246, 0.2); }
        h1 { font-size: 1.75rem; margin-top: 0; margin-bottom: 1rem; color: #93c5fd; }
        p { line-height: 1.6; margin-bottom: 1rem; }
        ul { padding-left: 1.25rem; margin-bottom: 1.5rem; }
        li { margin-bottom: 0.5rem; }
        code { background: rgba(59, 130, 246, 0.15); padding: 0.2rem 0.4rem; border-radius: 0.35rem; color: #bfdbfe; }
        .details { margin-top: 1.5rem; padding: 1rem; border-radius: 0.75rem; background: rgba(148, 163, 184, 0.1); border: 1px solid rgba(148, 163, 184, 0.2); color: #cbd5f5; font-size: 0.9rem; word-break: break-word; }
    </style>
</head>
<body>
    <div class=\"error-card\">
        <h1>Database Connection Required</h1>
        <p>We couldn’t reach the database server, so the admin portal is temporarily unavailable. Please review the configuration below and try again.</p>
        <ul>";
    foreach ($supportTips as $tip) {
        echo '<li>' . htmlspecialchars($tip, ENT_QUOTES, 'UTF-8') . '</li>';
    }
    echo "</ul>
        <div class=\"details\"><strong>Last error message</strong><br>{$safeMessage}</div>
    </div>
</body>
</html>";
    exit();
}


// =========================================================================
// 2. SESSION AND FUNCTION DEFINITIONS
// =========================================================================

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$is_logged_in = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

if (!$is_logged_in) {
    header("Location: login.php");
    exit();
}

// ===========================================

// Functions have been moved to functions.php
require_once 'functions.php';



// ===========================================
// FORM HANDLER (Handles all POST requests)
// ===========================================

function handle_form_submission($pdo, $action, $post_data, $files = [])
{
    $result_message = "";
    $redirect_base = basename(__FILE__);

    switch ($action) {


        // --- ADMIN PROFILE UPDATE LOGIC ---
        case 'update_profile':
            $admin_id = $_SESSION['admin_id'] ?? null;
            if (!$admin_id) {
                header("Location: " . $redirect_base . "?msg=" . urlencode("Authentication required to update profile."));
                exit();
            }

            $result_message = update_admin_profile(
                $pdo,
                $admin_id,
                $post_data['new_username'] ?? '',
                $post_data['full_name'] ?? '',
                $post_data['email'] ?? '',
                $post_data['phone_number'] ?? '', // Phone number is optional in profile update
                $post_data['current_password'] ?? '',
                $post_data['new_password'] ?? '',
                $files['profile_image'] ?? null
            );

            header("Location: " . $redirect_base . "?module=user&submodule=profile&msg=" . urlencode($result_message));
            exit();

        // --- PRODUCT CRUD ACTIONS ---
        case 'add_product':
            require_once 'functions.php';
            $name = $post_data['name'] ?? '';
            $slug = generate_slug($name);
            $description = $post_data['description'] ?? '';
            $price = floatval($post_data['price'] ?? 0);
            $stock = intval($post_data['stock'] ?? 0);
            $category_id = intval($post_data['category_id'] ?? 0);
            $status = $post_data['status'] ?? 'Active';
            $image_url = $post_data['image_url'] ?? null;

            $result = add_product($pdo, $name, $slug, $description, $price, $stock, $category_id, $status, $image_url);
            $result_message = $result['message'];
            break;

        case 'edit_product':
            require_once 'functions.php';
            $id = intval($post_data['id'] ?? 0);
            $name = $post_data['name'] ?? '';
            $slug = generate_slug($name);
            $description = $post_data['description'] ?? '';
            $price = floatval($post_data['price'] ?? 0);
            $stock = intval($post_data['stock'] ?? 0);
            $category_id = intval($post_data['category_id'] ?? 0);
            $status = $post_data['status'] ?? 'Active';
            $image_url = $post_data['image_url'] ?? null;

            $result = update_product($pdo, $id, $name, $slug, $description, $price, $stock, $category_id, $status, $image_url);
            $result_message = $result['message'];
            break;

        case 'delete_product':
            require_once 'functions.php';
            $id = intval($post_data['id'] ?? 0);
            $result = delete_product($pdo, $id);
            $result_message = $result['message'];
            break;

        case 'clear_all_products':
            require_once 'functions.php';
            try {
                $stmt = $pdo->prepare("DELETE FROM products");
                $stmt->execute();
                $deleted_count = $stmt->rowCount();
                $result_message = "Successfully deleted {$deleted_count} product(s) from database.";
                $module = 'product';
                $submodule = 'products';
            } catch (PDOException $e) {
                error_log("Error clearing products: " . $e->getMessage());
                $result_message = "Error clearing products: " . $e->getMessage();
                $module = 'product';
                $submodule = 'products';
            }
            break;

        // --- CATEGORY CRUD ACTIONS ---
        case 'add_category':
            require_once 'functions.php';
            $name = $post_data['name'] ?? '';
            $slug = generate_slug($name);
            $description = $post_data['description'] ?? '';
            $status = $post_data['status'] ?? 'Active';

            $result = add_category($pdo, $name, $slug, $description, $status);
            $result_message = $result['message'];
            $submodule = 'categories';
            break;

        case 'edit_category':
            require_once 'functions.php';
            $id = intval($post_data['id'] ?? 0);
            $name = $post_data['name'] ?? '';
            $slug = generate_slug($name);
            $description = $post_data['description'] ?? '';
            $status = $post_data['status'] ?? 'Active';

            $result = update_category($pdo, $id, $name, $slug, $description, $status);
            $result_message = $result['message'];
            $submodule = 'categories';
            break;

        case 'delete_category':
            require_once 'functions.php';
            $id = intval($post_data['id'] ?? 0);
            $result = delete_category($pdo, $id);
            $result_message = $result['message'];
            $submodule = 'categories';
            break;

        // --- SUPPORT TICKET ACTIONS ---
        case 'update_ticket':
            require_once 'functions.php';
            $id = intval($post_data['id'] ?? 0);
            $status = $post_data['status'] ?? 'Open';
            $priority = $post_data['priority'] ?? null;
            $assigned_to = !empty($post_data['assigned_to']) ? intval($post_data['assigned_to']) : null;
            $admin_reply = $post_data['reply_message'] ?? null;

            $result = update_support_ticket($pdo, $id, $status, $priority, $assigned_to, $admin_reply);
            $result_message = $result['message'];
            $module = 'support';
            break;

        // --- ADMIN USER ACTIONS ---
        case 'delete_admin':
            require_once 'functions.php';
            $id = intval($post_data['id'] ?? 0);
            $result = delete_admin_user($pdo, $id);
            $result_message = $result['message'];
            $module = 'user';
            $submodule = 'admins';
            break;

        case 'update_order_status':
            $order_id = $post_data['id'] ?? null;
            $new_status = $post_data['status'] ?? null;

            if ($order_id && $new_status) {
                if (update_order_status($order_id, $new_status, $pdo)) {
                    $result_message = "Order #$order_id status successfully updated to **$new_status**.";
                } else {
                    $result_message = "Failed to update order status. Please check database configuration.";
                }
            } else {
                $result_message = "Error: Missing order ID or status.";
            }
            break;

        default:
            $result_message = "Error: Unknown action requested.";
            break;
    }

    // Default redirect for non-auth actions
    $module = $post_data['module'] ?? 'dashboard';
    $submodule = $post_data['submodule'] ?? '';
    header("Location: " . $redirect_base . "?module=$module&submodule=$submodule&msg=" . urlencode($result_message));
    exit();
}

// =========================================================================
// 3. TOP-LEVEL REQUEST HANDLER (Handles POST and GET actions)
// =========================================================================

// NEW ACTION: Handles request to return to login/clear session
if (isset($_GET['action']) && $_GET['action'] === 'return_to_login') {
    handle_login_redirect();
}

// Handle LOGOUT request



require_once 'functions.php';

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    // Re-check for required functions just in case the include failed earlier
    if (!function_exists('update_order_status')) {
        error_log("FATAL: Required functions were not loaded.");
        // Fallback to minimal response
        header("Location: " . basename(__FILE__) . "?msg=" . urlencode("FATAL: System functions failed to load."));
        exit();
    }
    handle_form_submission($pdo, $_POST['action'], $_POST, $_FILES ?? []);
}

// Check login status
$is_logged_in = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
$is_awaiting_otp = isset($_SESSION['admin_awaiting_otp']) && $_SESSION['admin_awaiting_otp'] === true;

$message = $_GET['msg'] ?? '';
$view = $_GET['view'] ?? '';

$is_register_page = $view === 'register';
$is_otp_page = $view === 'otp';

// State management to ensure correct view is shown
if ($is_logged_in) {
    $is_register_page = false;
    $is_otp_page = false;
} else if ($is_awaiting_otp) {
    $is_otp_page = true;
    $is_register_page = false;
} else if ($is_otp_page && !$is_awaiting_otp) {
    header("Location: " . basename(__FILE__) . "?msg=" . urlencode("Please log in first."));
    exit();
}

// Fetch display details
$admin_username = htmlspecialchars($_SESSION['admin_username'] ?? ($is_awaiting_otp ? $_SESSION['temp_admin_username'] : 'Admin'));
$admin_role = htmlspecialchars($_SESSION['admin_role'] ?? 'User');

// Fetch admin details for the profile page if logged in
$admin_details = [];
if ($is_logged_in && isset($_SESSION['admin_id'])) {
    $admin_details = get_admin_user_details($pdo, $_SESSION['admin_id']) ?: [];
    unset($admin_details['password_hash'], $admin_details['otp_code'], $admin_details['otp_expiry']);

    $profileImageUrl = get_admin_profile_image_url($_SESSION['admin_id']);
    if ($profileImageUrl) {
        $admin_details['profile_image_url'] = $profileImageUrl;
    }
}

// Fetch data from database for display
if ($is_logged_in) {
    // Initialize all variables with defaults first
    $mock_products = [];
    $mock_orders = [];
    $mockAddresses = [];
    $mock_categories = [];
    $mock_transactions = [];
    $mock_shipments = [];
    $mock_customers = [];
    $mock_support_tickets = [];
    $mock_admin_users = [];
    $kpi_data = [
        'totalRevenue' => 0,
        'totalOrders' => 0,
        'lowStockCount' => 0,
        'newCustomers' => 0,
        'topProducts' => []
    ];

    // Fetch data individually with error handling
    try {
        $mock_products = get_products_list($pdo);
    } catch (Exception $e) {
        error_log("Error fetching products: " . $e->getMessage());
    }
    try {
        $mock_orders = get_orders_list($pdo);
    } catch (Exception $e) {
        error_log("Error fetching orders: " . $e->getMessage());
    }
    try {
        $kpi_data = get_dashboard_kpis($pdo);
    } catch (Exception $e) {
        error_log("Error fetching KPIs: " . $e->getMessage());
    }
    try {
        $mock_categories = get_categories_list($pdo);
    } catch (Exception $e) {
        error_log("Error fetching categories: " . $e->getMessage());
    }
    try {
        $mock_transactions = get_transactions_list($pdo);
    } catch (Exception $e) {
        error_log("Error fetching transactions: " . $e->getMessage());
    }
    try {
        $mock_shipments = get_shipments_list($pdo);
    } catch (Exception $e) {
        error_log("Error fetching shipments: " . $e->getMessage());
    }
    try {
        $mock_customers = get_customers_list($pdo);
    } catch (Exception $e) {
        error_log("Error fetching customers: " . $e->getMessage());
    }
    try {
        $mock_support_tickets = get_support_tickets_list($pdo);
    } catch (Exception $e) {
        error_log("Error fetching tickets: " . $e->getMessage());
    }
    try {
        $mock_admin_users = get_admin_users_list($pdo);
    } catch (Exception $e) {
        error_log("Error fetching admins: " . $e->getMessage());
    }
    try {
        $mockAddresses = get_customer_addresses($pdo);
    } catch (Exception $e) {
        error_log("Error fetching addresses: " . $e->getMessage());
    }
} else {
    $mock_products = [];
    $mock_orders = [];
    $mockAddresses = [];
    $mock_categories = [];
    $mock_transactions = [];
    $mock_shipments = [];
    $mock_customers = [];
    $mock_support_tickets = [];
    $mock_admin_users = [];
    $kpi_data = [];
}


// =========================================================================
// 4. CONDITIONAL HTML RENDERING (LOGIN/REGISTER/OTP PAGE or ADMIN DASHBOARD)
// =========================================================================
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="../image/logo.png?v=3.5">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
    if ($is_logged_in) {
        echo 'IMARKETPH  ADMIN PORTAL';
    } else if ($is_otp_page) {
        echo 'OTP Verification | IMARKETPH';
    } else if ($is_register_page) {
        echo 'Admin Registration | IMARKETPH';
    } else {
        echo 'Admin Login | IMARKETPH';
    }
    ?></title>
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/admin/dashboard.css">
    <style>

    </style>
</head>

<body>

    <!-- Sidebar / Navigation -->
    <?php include '../Components/admin/sidebar.php'; ?>

    <!-- Main Content Area -->
    <main class="main-content">
        <header class="main-header">
            <!-- Pangkalahatang Tanaw title area -->
            <div class="page-title-container">
                <!-- H1 is hidden on large screens to avoid layout duplication with H2 in content -->
                <h1 class="header-title" id="page-title">Dashboard & Analytics</h1>
            </div>

            <div class="header-right">
                <div class="profile-menu-container" tabindex="0">
                    <div class="profile-avatar"
                        style="width: 2.5rem; height: 2.5rem; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); transition: all 0.2s; border: 2px solid rgba(255, 255, 255, 0.2);">
                        <?php echo strtoupper(substr($admin_username, 0, 1)); ?>
                    </div>

                    <div class="profile-dropdown">
                        <div
                            style="padding: 0.75rem 1rem; color: #1f2937; font-weight: 600; border-bottom: 1px solid #f9fafb;">
                            <?php echo $admin_username; ?>
                            <span class="text-xs font-medium"
                                style="display: block; color: var(--color-indigo-600); margin-top: 0.25rem;"><?php echo $admin_role; ?></span>
                        </div>
                        <a href="#" onclick="showSubModule('user', 'profile'); event.preventDefault();">
                            <i data-lucide="user-cog" style="width: 1.1rem; height: 1.1rem; margin-right: 0.75rem;"></i>
                            Admin Profile
                        </a>
                        <div class="divider"></div>
                        <a href="logout.php" style="color: var(--color-red-600);">
                            <i data-lucide="log-out" style="width: 1.1rem; height: 1.1rem; margin-right: 0.75rem;"></i>
                            Log Out
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Module Content Container -->
        <div id="content-container">
            <!-- Dynamic content will be loaded here -->
        </div>
    </main>

    <!-- Custom Modal/Message Box (Replaces alert()/confirm()) -->
    <div id="custom-modal-backdrop" class="modal-backdrop hidden">
        <div id="modal-container" class="modal-content">
            <!-- Content dynamically injected here -->
        </div>
    </div>

    <script>
        // Use PHP to safely inject the addresses array
        const mockAddresses = <?php echo json_encode($mockAddresses); ?>;

        // Inject data from PHP
        const kpiData = <?php echo json_encode($kpi_data); ?>;
        const productsData = <?php echo json_encode($mock_products); ?>;
        const ordersData = <?php echo json_encode($mock_orders); ?>;
        const adminDetails = <?php echo json_encode(!empty($admin_details) ? $admin_details : new stdClass()); ?>;
        const categoriesData = <?php echo json_encode($mock_categories); ?>;
        const transactionsData = <?php echo json_encode($mock_transactions); ?>;
        const shipmentsData = <?php echo json_encode($mock_shipments); ?>;
        const customersData = <?php echo json_encode($mock_customers); ?>;
        const supportTicketsData = <?php echo json_encode($mock_support_tickets); ?>;
        const adminUsersData = <?php echo json_encode($mock_admin_users); ?>;

        const formatCurrency = (amount) => {
            return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(amount);
        };

        // Additional configuration for JS
        const adminConfig = {
            username: "<?php echo $admin_username; ?>",
            role: "<?php echo $admin_role; ?>",
            currentAdminId: <?php echo $_SESSION['admin_id'] ?? 0; ?>
        };
    </script>
    <script src="../javascript/admin/Dashboard.js"></script>
</body>

</html>
