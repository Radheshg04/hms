<?php require_once '../vendor/autoload.php';
require_once 'secret.php';
\Stripe\Stripe::setApiKey($secretKey);

$checkout_session = \Stripe\Checkout\Session::create([
    'line_items' => [[
      'price' => 'price_1P44oOSDkYVNNJsLNN5vth4Q',
      'quantity' => 1,
    ]],
    'currency' => 'inr',
    // 'country' => 'india',
    'mode' => 'payment',
    'success_url' => 'http://localhost/hms/paywall/success.php',
    'cancel_url' => 'http://localhost/hms/paywall/failure.html',
  ]);?>

<head>
    <title>Checkout</title>
    <script src = "https://js.stripe.com/v3"></script>
</head>
  <body>
      <script type="text/javascript">
        var stripe = Stripe('pk_test_51P43wqSDkYVNNJsL1wVHMrmRh9oP0dLMI5B8wVuFV2goGIAlacGFe8O9u5qK7232KIz5diGnWB8P6y3CzlNwYEzH00YXeHf2WL');
        var session = "<?php echo $checkout_session['id'];?>";
        stripe.redirectToCheckout({sessionId: session})
        .then(function(result){
          if(result.error){
            alert(result.error.message);
          }
        })
        .catch(function(error) {
          console.error("Error: ",error);
        });

      </script>
  </body>
</html>