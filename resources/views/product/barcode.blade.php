<!DOCTYPE html>
<html>
<head>
   <title>Cetak Barcode</title>
</head>
<body>
   <table width="100%">   
     <tr>
      
      @foreach($dataProduct as $data)
      <td align="center" style="border: 1px solid #ccc">
      {{ $data->name_product}} - Rp. {{ format_money($data->selling_price) }}</span><br>
      <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG( $data->code_product, 'C39') }}" height="60" width="180">
      <br>{{ $data->code_product}}
      </td>
      @if( $no++ % 3 == 0)
         </tr><tr>
      @endif
     @endforeach
     
     </tr>
   </table>
</body>
</html>