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
    <h2>Pay via {{$paymentOption}}</h2>
    <p>Hi {{ $name }},</p>
    <p>
      Please kindly proceed to your payment of <strong>RM {{$amount}}</strong> via
      {{$paymentOption}} to:
    </p>
    <hr class="thin-divider">
    @if($paymentOption==='Bank Transfer')
    <h2 class="center-thin-h2">
      CIMB <br />7061620467<br />Chiah Yi Jie
    </h2>
    @else
    <img src="https://yj-artjournal-api.herokuapp.com/TNG.JPG" class="center" style="width: 450px;" />
    @endif
    <hr class="thin-divider">
    <p>
      Reminder* <br />
      Payment has to be done within 24 hrs for your order to be processed, or your order will be cancelled.
    </p>
    <table class="product-table">
      <tr>
        <th>Item</th>
        <th>Qty</th>
        <th>Price (RM)</th>
      </tr>
      @foreach ($products as $product)
      <tr class="product">
        <td>{{$product['id']}}</td>
        <td class="center">{{$product['quantity']}}</td>
        <td class="currency-align">{{$product['totalPrice']}}</td>
      </tr>
      @endforeach
      <tr>
        <td><strong>Total Amount</strong></td>
        <td colspan="2" class="currency-align"><strong>{{$totalAmount}}</strong></td>
      </tr>
      <tr>
        <td class="green-text"><strong>Discount</strong></td>
        <td colspan="2" class="currency-align green-text"><strong>-{{$totalDiscount}}</strong></td>
      </tr>
      <tr>
        <td><strong>Shipping Fee</strong></td>
        <td colspan="2" class="currency-align"><strong>{{$shippingFee}}</strong></td>
      </tr>
      <tr>
        <td><strong>Total After Discount</strong></td>
        <td colspan="2" class="currency-align"><strong>{{$totalAfterDiscount}}</strong></td>
      </tr>
    </table>
    <p>
      <span style="font-weight: 600">Note to Seller:</span> <br /> {{$note}}
    </p>
    <p>
      We will verify your payment and send a receipt via email shortly.<br />
      Free feel to contact me at <a href="mailto:hello@yjartjournal.com">hello@yjartjournal.com</a>.
    </p>
    <h2 class="center-thin-h2">Have A Great Day!</h2>
    <p style="font-style: italic;margin-top:0px" class="center">
      "When you buy from a small business, an actual person does a little happy dance."
    </p>
    <p>Regards<br />YJ Art Journal</p>
    <hr class="thick-divider">
    <p style="font-weight:bold">Delivery Details</p>
    <table>
      <tr>
        <td>Name:</td>
        <td>{{$receiverName}}</td>
      </tr>
      <tr>
        <td>Contact No:</td>
        <td>{{$phoneNo}}</td>
      </tr>
      <tr>
        <td>Address:</td>
        <td>{{$addressLine1}} {{$addressLine2}} {{$postcode}} {{$city}} {{$state}} {{$country}}</td>
      </tr>
    </table>
    <hr class="thick-divider">
  </div>
</body>

<style>
  .center {
    align-self: center;
    text-align: center
  }

  p {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
  }

  h2 {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
  }

  table {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
  }

  .product-table td,
  th {
    border: 1px solid #F5DBC9;
    padding: 8px;
  }

  .product:nth-child(even) {
    background-color: #F5DBC9;
  }

  .currency-align {
    text-align: right
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

  .green-text {
    color: green
  }

  .center-thin-h2 {
    font-weight: normal;
    text-align: center
  }
</style>

</html>