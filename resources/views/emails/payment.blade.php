<!DOCTYPE html>
<html lang="en-US">

<head>
  <meta charset="utf-8" />
</head>

<body>
  <div style="justify-content:center;display:flex;flex-direction:column; margin-left:100px;margin-right:100px">
    <img src="https://yj-artjournal-api.herokuapp.com/icon.png"
      style="height: 150px; width: 150px; align-self:center" />
    {{-- src={{asset('icon.png')}} --}}
    <hr style="border-top: 3px solid #B67B5E; border-radius: 5px; width: 100%; margin-top: 20px">
    <h2 class="customFont">
      Pay via {{$paymentOption}}
    </h2>
    <p class="customFont">Hi {{ $name }},</p>
    <p class="customFont">
      Please kindly proceed to your payment of <strong>RM {{$amount}}</strong> via
      {{$paymentOption}} to:
    </p>
  </div>
</body>

<style>
  .customFont {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
  }
</style>

</html>