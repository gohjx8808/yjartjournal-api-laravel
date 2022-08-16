<!DOCTYPE html>
<html lang="en-US">

<head>
  <meta charset="utf-8" />
</head>

<body>
  <div style="justify-content:center;display:flex;flex-direction:column; margin-left:100px;margin-right:100px">
    <img src="https://yj-artjournal-api.herokuapp.com/icon.png" class="center" style="height: 150px; width: 150px;" />
    {{-- src={{asset('icon.png')}} --}}
    <hr class="thick-divider">
    <h2 class="customFont">
      Pay via {{$paymentOption}}
    </h2>
    <p class="customFont">Hi {{ $name }},</p>
    <p class="customFont">
      Please kindly proceed to your payment of <strong>RM {{$amount}}</strong> via
      {{$paymentOption}} to:
    </p>
    <hr class="thin-divider">
    @if($paymentOption==='Bank Transfer')
    <h2 class="customFont center" style="font-weight: normal;text-align:center">
      CIMB <br />7061620467<br />Chiah Yi Jie
    </h2>
    @else
    <img src="https://yj-artjournal-api.herokuapp.com/TNG.JPG" class="center" style="height: 150px; width: 150px;" />
    @endif
    <hr class="thin-divider">
  </div>
</body>

<style>
  .center {
    align-self: center
  }

  .customFont {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
  }

  .thick-divider {
    border-top: 3px solid #B67B5E;
    border-radius: 5px;
    width: 100%;
    margin-top: 20px;
  }

  .thin-divider {
    border-top: 1px solid #B67B5E;
    border-radius: 5px;
    width: 100%;
    margin-top: 20px;
  }
</style>

</html>