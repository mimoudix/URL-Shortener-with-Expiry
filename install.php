<?php

// Get the base URL where the script is installed
$base_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the database credentials from the form
    $host = $_POST['host'];
    $dbname = $_POST['dbname'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Try to establish a PDO database connection with the provided credentials
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    } catch (PDOException $e) {
        // Redirect back to installation page with an error message if the connection fails
        header("Location: /install.php?error=connection");
        exit();
    }

    // Create a new config file with the provided database credentials
    $config_file = fopen("config.php", "w");
    fwrite($config_file, "<?php\n");
    fwrite($config_file, "// Define database credentials\n");
    fwrite($config_file, "define('DB_HOST', '$host');\n");
    fwrite($config_file, "define('DB_NAME', '$dbname');\n");
    fwrite($config_file, "define('DB_USER', '$username');\n");
    fwrite($config_file, "define('DB_PASSWORD', '$password');\n");
    fwrite($config_file, "\n");
    fwrite($config_file, "// Define base URL\n");
    fwrite($config_file, "define('SYSTEM_URL', '$base_url');\n");
    fwrite($config_file, "\n");
    fwrite($config_file, "// Establish PDO database connection\n");
    fwrite($config_file, "try {\n");
    fwrite($config_file, "    \$pdo = new PDO(\"mysql:host=\" . DB_HOST . \";dbname=\" . DB_NAME, DB_USER, DB_PASSWORD);\n");
    fwrite($config_file, "} catch (PDOException \$e) {\n");
    fwrite($config_file, "    // Redirect to installation page if there was an error connecting to the database\n");
    fwrite($config_file, "    header(\"Location: /install.php\");\n");
    fwrite($config_file, "    exit();\n");
    fwrite($config_file, "}");
    fclose($config_file);

    // Create the short_urls table if it does not exist
    $pdo->exec("CREATE TABLE IF NOT EXISTS short_urls (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        long_url TEXT NOT NULL,
        short_code VARCHAR(6) NOT NULL,
        expiry_date DATETIME NOT NULL
    )");

    // Redirect to the homepage
    header("Location: /");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Installation</title>
    <link rel="stylesheet" href="css/tailwind.css">
</head>

<body>
    <?php if (isset($_GET['error']) && $_GET['error'] == 'connection') : ?>
        <p style="color: red;">Error: Could not establish a database connection with the provided credentials.</p>
    <?php endif; ?>
    <!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
    <div class="isolate bg-white py-24 px-6 sm:py-32 lg:px-8">
        <div class="absolute inset-x-0 top-[-10rem] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[-20rem]">
            <svg class="relative left-1/2 -z-10 h-[21.1875rem] max-w-none -translate-x-1/2 rotate-[30deg] sm:left-[calc(50%-40rem)] sm:h-[42.375rem]" viewBox="0 0 1155 678">
                <path fill="url(#45de2b6b-92d5-4d68-a6a0-9b9b2abad533)" fill-opacity=".3" d="M317.219 518.975L203.852 678 0 438.341l317.219 80.634 204.172-286.402c1.307 132.337 45.083 346.658 209.733 145.248C936.936 126.058 882.053-94.234 1031.02 41.331c119.18 108.451 130.68 295.337 121.53 375.223L855 299l21.173 362.054-558.954-142.079z" />
                <defs>
                    <linearGradient id="45de2b6b-92d5-4d68-a6a0-9b9b2abad533" x1="1155.49" x2="-78.208" y1=".177" y2="474.645" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#9089FC" />
                        <stop offset="1" stop-color="#FF80B5" />
                    </linearGradient>
                </defs>
            </svg>
        </div>
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">MimoudiX Installer</h2>
            <p class="mt-2 text-lg leading-8 text-gray-600">please fill in your database credentials</p>
        </div>
        <form action="#" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20">
            <div class="grid grid-cols-1 gap-y-6 gap-x-8 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="host" class="block text-sm font-semibold leading-6 text-gray-900">Host</label>
                    <div class="mt-2.5">
                        <input type="text" name="host" id="host" autocomplete="off" class="block w-full rounded-md border-0 py-2 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="dbname" class="block text-sm font-semibold leading-6 text-gray-900">Database Name</label>
                    <div class="mt-2.5">
                        <input type="text" name="dbname" id="dbname" autocomplete="off" class="block w-full rounded-md border-0 py-2 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="username" class="block text-sm font-semibold leading-6 text-gray-900">Database Username</label>
                    <div class="mt-2.5">
                        <input type="username" name="username" id="username" autocomplete="off" class="block w-full rounded-md border-0 py-2 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="password" class="block text-sm font-semibold leading-6 text-gray-900">Database Password</label>
                    <div class="mt-2.5">
                        <input type="password" name="password" id="password" autocomplete="off" class="block w-full rounded-md border-0 py-2 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="system_url" class="block text-sm font-semibold leading-6 text-gray-900">System URL</label>
                    <div class="mt-2.5">
                        <input type="text" name="system_url" id="system_url" value="<?php echo $base_url; ?>" disabled autocomplete="off" class="block w-full rounded-md border-0 py-2 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
            </div>
            <div class="mt-10">
                <button type="submit" class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Install</button>
            </div>
        </form>
    </div>


</body>

</html>