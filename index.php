<?php
// Check if config file exists
if (!file_exists('config.php')) {
    header("Location: /install");
    exit();
}

// Include config file
require_once('config.php');
// Rest of your code here...
?>
<!DOCTYPE html>
<html>

<head>
    <title>URL Shortener</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <link rel="stylesheet" href="css/tailwind.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-slate-100">
    <div class="text-center mt-16">
        <h1 class="text-6xl tracking-tight font-extrabold text-gray-900">
            Another <span class=" text-indigo-600 ">link </span> Shortener
        </h1>
        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
            v1.0
        </span>
        <p class="mt-3 max-w-md mx-auto  text-gray-500  md:mt-5 text-xl md:max-w-3xl">
            Are long and messy links driving you crazy? It's time to link up with <span class="text-indigo-600 ">an URL Shortener</span><br> the Link-fiesta that puts all your links in one short. Sign up now and get organized!
        </p>
        <div class="mt-16 mx-auto max-w-7xl px-4">
            <div class=" mt-4 sm:mt-0 sm:ml-3">
                <svg class="w-4 h-4 absolute top-0 right-0 m-3 pointer-events-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
                <select id="expiry-dropdown" class="border rounded-full border-gray-300 text-gray-600 h-10 pl-2 pr-10 bg-white hover:border-gray-400 focus:outline-none appearance-none">
                    <option value="1hr">1 Hour</option>
                    <option value="10hr">10 Hours</option>
                    <option value="24hr" selected>24 Hours</option>
                    <option value="1wk">1 Week</option>
                    <option value="1mo">1 Month</option>
                    <option value="0">No Expiry</option>
                </select>
            </div>
            <div class="mt-6 sm:mx-auto sm:max-w-lg sm:flex">
                <div class="min-w-0 flex-1">
                    <label for="url-input" class="sr-only">URL</label>
                    <input id="url-input" type="url" class="block w-full border border-transparent rounded-md px-5 py-3 text-base text-gray-900 placeholder-gray-500 shadow-sm focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600" placeholder="https://AnnoyingLinkHere.com">
                </div>


                <div class="mt-4 sm:mt-0 sm:ml-3">
                    <button id="submit-button" class="block w-full rounded-md border border-transparent px-5 py-3 bg-indigo-500 text-base font-medium text-white shadow hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600 sm:px-10">Shortify !</button>
                </div>
            </div>
        </div>

        <p id="output" class="mt-4 animate-pulse text-base font-semibold text-indigo-600">
        </p>
    </div>



    </div>
    <script>
        $(document).ready(function() {
            $('#submit-button').click(function() {
                var url = $('#url-input').val();
                var expiry = $('#expiry-dropdown').val();
                $.ajax({
                    type: 'POST',
                    url: 'generate.php',
                    data: {
                        url: url,
                        expiry: expiry
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#output').html('<a href="' + response.short_url + '">' + response.short_url + '</a>');
                        } else {
                            $('#output').html('<div class="error">' + response.error + '</div>');
                        }
                    },
                    error: function() {
                        $('#output').html('<div class="error">An error occurred while generating the short URL.</div>');
                    }
                });
            });
        });
    </script>
</body>

</html>
