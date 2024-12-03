<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pdf</title>
    <style>
      	p {
				margin-bottom: 0px;
				margin-top: 0px;
			}
        div {
            border-style: solid;
            padding: 5px;
            width:6cm;
        }
    </style>
</head>
<body>
    <div>
        <table width="6cm">
				<tr>
					<td width="2.5cm"  rowspan="4">
                        <img src="data:image/png;base64,{!! base64_encode($qr) !!}" alt="">
                    </td>
					<td  height="5px">
						<p align="center"><font size=1><strong>CÓDIGO: </strong></p>
					</td>
				</tr>
                <tr width="2.5cm">
					<td  height="5px">
						<p  align="center" ><font size=2><strong>{{$actual->codigo}}</strong></font></p>
					</td>
				</tr>
				<tr width="2.5cm">
					<td  height="5px">
						<p align="center"><font size=1><strong>{{$codcont->nombre}}</strong></p>
					</td>
				</tr>

				<tr width="2.5cm">
					<td  height="5px">
						<p  align="center" ><font size=1><strong>{{$auxiliar->nomaux}}</strong></font></p>
					</td>
				</tr>
		</table>
</div>
</body>
</html>