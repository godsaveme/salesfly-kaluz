<?php require_once(dirname(__FILE__) . "/escpos-php-master/Escpos.php");
							//$logo = new EscposImage("images/productos/tostao.jpg");
							$printer = new Escpos();
							/* Print top logo */
                            $printer -> setJustification(Escpos::JUSTIFY_CENTER);
                            //$printer -> graphics($logo);
							$printer -> selectPrintMode(Escpos::MODE_DOUBLE_WIDTH);
							$printer -> text("Bienvenidos a\nLas Pirkas");
							$printer -> feed();
							$printer -> selectPrintMode();
							$printer -> setJustification(Escpos::JUSTIFY_LEFT);
							$printer -> feed();
							$printer -> text("Ticket N°: 14");
							$printer -> feed();
							$printer -> text("Fecha y Hora: 2015-12-07 16:15:31\n");
							$printer -> text("Cajero: Javier Jesús Alvarez Montenegro");
							$printer -> feed();
							$printer -> text("------------------------------------------\n");
							$printer -> text("Concepto: ");
							$printer -> setEmphasis(true);
                            $printer -> text("Paseo en bote");
                            $printer -> setEmphasis(false);
                            $printer -> feed();
                            $printer -> text("Precio Unit. S/.: ");
                            $printer -> text("5.00");
                            $printer -> feed();
                            $printer -> text("Cantidad: ");
                            $printer -> text("2");
                            $printer -> feed();
                            $printer -> text("TOTAL S/.: ");
                            $printer -> setEmphasis(true);
                            $printer -> text("10.00");
                            $printer -> setEmphasis(false);
                            $printer -> feed();


							$printer -> text("------------------------------------------\n");$printer -> feed();$printer -> setJustification(Escpos::JUSTIFY_CENTER);$printer -> text("¡Llene sus datos y deposite este ticket en las ánforas para el sorteo navideño!\n");$printer -> feed();$printer -> selectPrintMode();$printer -> text("Nombres/Rzon Soc.:__________________________________________________________________\n");$printer -> text("Direcc.:__________________________________\n");$printer -> text("DNI/RUC.:_________________________________\n");$printer -> text("Teléfono.:________________________________\n");$printer -> text("Correo.:__________________________________\n");$printer -> feed();$printer -> text("Fecha de Impr.: 07-12-2015 16:15:32\n");$printer -> text("<<No válido como documento contable>>\n");$printer -> feed();$printer -> cut();$printer -> close();