
<?php
// TODO: change with your actual server_key that can be found on Merchant Administration Portal (MAP)
//$server_key = "1a794e3f-f023-4cda-92b7-dcb7a22a46ff";
$server_key = "6d7ccd71-ea52-43cc-ac42-5402077bd6c6";
// TODO : change to production URL for your production Environment
// sandbox/development/testing environment:
$endpoint = "https://api.sandbox.veritrans.co.id/v2/charge";
// production environment:
//$endpoint = "https://api.sandbox.veritrans.co.id/v2/charge";
$transaction_details = array(
        'order_id'                 => $_POST["order_id"],
        'gross_amount'         => $_POST["gross_amount"]
);
// Populate items
$items = [
        array(
                'id'                 => $_POST["item_id"],
                'price'         => $_POST["item_price"],
                'quantity'         => $_POST["item_quantity"],
                'name'                 => $_POST["item_name"]
        ),
        array(
                'id'                => 'item2',
                'price'         => 50000,
                'quantity'         => 2,
                'name'                 => 'Nike N90'
        )
];
// Populate customer's billing address
$billing_address = array(
        'first_name'         => $_POST["first_name"],
        'last_name'         => $_POST["last_name"],
        'address'                 => $_POST["address"],
        'city'                         => $_POST["city"],
        'postal_code'         => $_POST["postal_code"],
        'phone'                 => $_POST["phone"],
        'country_code'         => $_POST["country_code"]
        );
// Populate customer's shipping address
$shipping_address = array(
        'first_name'         => $_POST["first_name_d"],
        'last_name'         => $_POST["last_name_d"],
        'address'                 => $_POST["address_d"],
        'city'                         => $_POST["city_d"],
        'postal_code'         => $_POST["postal_code_d"],
        'phone'                 => $_POST["phone_d"],
        'country_code'         => $_POST["country_code_d"]
        );
// Populate customer's Info
$customer_details = array(
        'first_name'         => $_POST["first_name"],
        'last_name'         => $_POST["last_name"],
        'email'                 => $_POST["email"],
        'phone'                 => $_POST["phone"],
        'billing_address'  => $billing_address,
        'shipping_address' => $shipping_address
        );
// Data yang akan dikirim untuk request redirect_url.
// Uncomment 'secure' => true jika transaksi ingin diproses dengan 3DSecure.
$transaction_data = array(
        'payment_type'                         => 'vtweb',
        'vtweb'                         => array(
                'enabled_payments'         => ['credit_card']
        ),
        //'secure'                                => true,
        'transaction_details'         => $transaction_details,
        'item_details'                         => $items,
        'customer_details'                 => $customer_details
);
$json_transaction_data = json_encode($transaction_data);
// Mengirimkan request dengan menggunakan CURL
// HTTP METHOD : POST
// Header:
//        Content-Type : application/json
//        Accept: application/json
//         Basic Auth using server_key
$request = curl_init($endpoint);
curl_setopt($request, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($request, CURLOPT_POSTFIELDS, $json_transaction_data);
curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
$auth = sprintf('Authorization: Basic %s', base64_encode($server_key.':'));
curl_setopt($request, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
        'Accept: application/json',
        $auth
        )
);
echo $json_transaction_data;
// Excute request and parse the response
$response = json_decode(curl_exec($request));
echo $response;

$result = file_get_contents('http://requestb.in/slj6x2sl');
echo $result;

// Check Response
// if($response->status_code == "201")
// {
//         //success
//         //redirect to vtweb payment page
//         header("Location: ".$response->redirect_url);
// }
// else
// {
//         //error
//         echo "Terjadi kesalahan pada data transaksi yang dikirim.<br />";
//         echo "Status message: [".$response->status_code."] ".$response->status_message;
//         echo "<h3>Response:</h3>";
//         var_dump($response);
// }
?>