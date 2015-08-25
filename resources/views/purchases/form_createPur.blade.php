


        <!--================================================================================-->
        <section class="content-header">
          <h1>
            Orden de Compras
            <small>Panel de Control</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="/stores">Orden de Compras</li>
            <li class="active">Crear</li>
          </ol>

          
        </section>
<!--===========================================================================================-->
<section class="content">

<div class="row">
<div class="col-md-12">

<div class="box box-primary" >
                             <div class="box-header with-border">
                                   <h3 class="box-title">Crear Pedido de Compras</h3>
                             </div><!-- /.box-header -->
                <!-- form start -->
 <form name="orderPurchaseCreateForm" role="form" novalidate>
            <div class="box-body" >
                  <div class="callout callout-danger" ng-show="errors">
                                                  <ul>
                                              <li ng-repeat="row in errors track by $index"><strong >@{{row}}</strong></li>
                                              </ul>
                 </div>
  <div class="box-body">           
    <div class="row">
          <div class="col-md-1">
          </div>
         <!-- <div class="col-md-4">
              <div class="form-group" ng-class="{true: 'has-error'}[ orderPurchaseCreateForm.empresa.$error.required && orderPurchaseCreateForm.$submitted || orderPurchaseCreateForm.empresa.$dirty && orderPurchaseCreateForm.empresa.$invalid]">
                    <label>Proveedor: </label>
                    <div ng-hide="show" class="input-group">
                               <input  type="text" ng-model="orderPurchase.empresa"  name="empresa" class="form-control input-sm pull-right" placeholder="Search" required/>
                                                             
                                <div class="input-group-btn">
                                 <button class="btn btn-sm btn-default" data-toggle="modal" ng-click="searchsupplier()" data-target="#miventana" ><i class="fa fa-search"></i></button>
                               </div>
                   </div>
                   <label ng-show="orderPurchaseCreateForm.$submitted || orderPurchaseCreateForm.empresa.$dirty && orderPurchaseCreateForm.empresa.$invalid">
                                    <span ng-show="orderPurchaseCreateForm.empresa.$error.required"><i class="fa fa-times-circle-o"></i>Requerido.</span>
                                </label>
                    <div ng-show="show" class="input-group">
                               <spam ng-show="show">@{{orderPurchase.empresa}}</spam>

                    </div> 
              </div> 
            </div>-->
             <div class="col-md-4">
          <div class="form-group" ng-class="{true: 'has-error'}[ orderPurchaseCreateForm.empresa.$error.required && orderPurchaseCreateForm.$submitted || orderPurchaseCreateForm.empresa.$dirty && orderPurchaseCreateForm.empresa.$invalid]">
              <label>Proveedor: </label>
              <div class="input-group" ng-hide="show">
              
               
               <input typeahead-on-select="asignarEmpresa()" type="text" name="empresa" ng-model="purchase.empresa" placeholder="por hajajaj" 
                     typeahead="supplier as supplier.empresa for supplier in suppliers | filter:$viewValue | limitTo:8"  
                     typeahead-loading="loadingLocations" typeahead-no-results="noResults" class="form-control"
                     tooltip="Ingrese caracteres para busacar Proveedor por Empres" required>
                    <i ng-show="loadingLocations" class="glyphicon glyphicon-refresh"></i>
                    <div ng-show="noResults">
                            <i class="glyphicon glyphicon-remove"></i> No Results Found
                    </div>
             
                </div> 
                <label ng-show="orderPurchaseCreateForm.$submitted || orderPurchaseCreateForm.empresa.$dirty && orderPurchaseCreateForm.empresa.$invalid">
                                    <span ng-show="orderPurchaseCreateForm.empresa.$error.required"><i class="fa fa-times-circle-o"></i>Requerido.</span>
                                </label>
                <div ng-show="show" class="input-group">
                      <spam ng-show="show">@{{purchase.empresa}}</spam>
                </div>
        </div>
      </div>

          
                    <!--)=========================================================================-->
           <div class="col-md-3">

                      <div  class="form-group" ng-class="{true: 'has-error'}[ orderPurchaseCreateForm.fechaPedido.$error.required && orderPurchaseCreateForm.$submitted || orderPurchaseCreateForm.fechaPedido.$dirty && orderPurchaseCreateForm.fechaPedido.$invalid]">
                                <label for="fechaPedido">Fecha Entrega: </label>
                            <div ng-hide="show" class="input-group">
                                <div class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                </div>
                                  <input type="date" class="form-control"  name="fechaPedido" ng-model="purchase.fechaEntrega" >
                            </div>
                            <label ng-show="orderPurchaseCreateForm.$submitted || orderPurchaseCreateForm.fechaPedido.$dirty && orderPurchaseCreateForm.fechaPedido.$invalid">
                            <span ng-show="orderPurchaseCreateForm.fechaPedido.$invalid"><i class="fa fa-times-circle-o"></i>Fecha Inválida.</span>
                            </label>
                             
                             <div ng-show="show" class="input-group">
                               <spam >@{{purchase.fechaEntreg}}</spam>
                    </div> 
                      </div>  
                      
          </div>
         
     
          <div class="col-md-3">
                   <div class="form-group" ng-class="{true: 'has-error'}[ orderPurchaseCreateForm.warehouse.$error.required && orderPurchaseCreateForm.$submitted || orderPurchaseCreateForm.warehouse.$dirty && orderPurchaseCreateForm.warehouse.$invalid]">
                       <label for="Tienda">Almacen: </label>
                       <select ng-hide="show" class="form-control" name="warehouse" ng-click="seleccionarWarehouse()" ng-model="purchase.warehouses_id" ng-options="item.id as item.nombre for item in warehouses" required>
                       <option value="">--Elija warehouses_id--</option>
                       </select>
                       <label ng-show="orderPurchaseCreateForm.$submitted || orderPurchaseCreateForm.warehouse.$dirty && orderPurchaseCreateForm.warehouse.$invalid">
                                <span ng-show="orderPurchaseCreateForm.warehouse.$invalid"><i class="fa fa-times-circle-o"></i>Requerido.</span>
                      </label>
                       <div ng-show="show" class="input-group">
                               <spam>@{{warehouses.nombre}}</spam>
                           </div>
                    </div>
          </div>
     </div>
     <div class="row">
          <div class="col-md-1">
          </div>
          <div class="col-md-4">    
      <div class="form-group">
                
                <button ng-hide="show" type="submit" ng-click="Warehouses()" class="btn btn-default btn-xs">Guardar y Continuar</button>
                <a ng-show="show" ng-click="" class="btn btn-default btn-xs">Editar</a>
     
      </div>
      </div>
    </div>
 
             <!--   <div ng-app>
                         <a ng-click="purchase.$show()" ng-show="!purchase.$visible" ediable-text="userxx.name">@{{ userxx.name }}</a>
                </div>-->
            </div>
            <!--===================================================================================-->
            
          <!--==================================================================================-->
  <div ng-show="show"  class="box" name="DetalleOrden">
        <div class="box box-default" id="box-addPro">
        <div class="box-header with-border">
          <h3 class="box-title">Agregar Producto</h3>
          <div class="box-tools pull-right">
            <button  type="submit" class="btn btn-box-tool" data-widget="collapse"><i  class="fa fa-minus"></i></button>
          
          </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body" style="display: block;">

        <form name="detailPurchaseCreateForm" role="form" novalidate> 
          <div class="row">
             <div class="col-md-1"></div>
            <div class="col-md-4">
          <div class="input-group">
              <label>Producto</label>
                
               <input typeahead-on-select="asignarProduc1()" type="text" ng-model="product.proId" placeholder="Locations loaded via $http" 
          typeahead="product as product.proNombre+' /'+product.NombreAtributos for product in products | filter:$viewValue | limitTo:8" 
          typeahead-loading="loadingLocations" typeahead-no-results="noResults" class="form-control"
           tooltip="Ingrese caracteres para busacar producto por nombre"
            >
         
                    <i ng-show="loadingLocations" class="glyphicon glyphicon-refresh"></i>
            <div ng-show="noResults">
                    <i class="glyphicon glyphicon-remove"></i> No Results Found
           </div>
            
        </div> 
            </div> 
           <div class="col-md-4">
          <div class="input-group">
              <label>Variante</label>
               
               <input typeahead-on-select="asignarProduc2()" type="text" ng-model="variant.sku" placeholder="Busca por producto" 
          typeahead="variant as variant.sku for variant in variants | filter:$viewValue | limitTo:8"  
          typeahead-loading="loadingLocations" typeahead-no-results="noResults" class="form-control"
          tooltip="Ingrese caracteres para busacar producto por sku">
         
                    <i ng-show="loadingLocations" class="glyphicon glyphicon-refresh"></i>
            <div ng-show="noResults">
                    <i class="glyphicon glyphicon-remove"></i> No Results Found
           </div>
             
        </div> 
      </div>
      <div class="col-md-1">
      <div class="input-group">
      <label></label><br/>
           <input type="checkbox" name="vehicle"  ng-click="llenar()" >Base<br>
      </div>
    </div>
           

          </div>

        
           <!-------------------------------------------------------------------------->
          <div class="row">
           <div class="col-md-1">
           </div>
           <div class="col-md-10">
             <hr>
          
            <div collapse="mostrarPresentacion">
          <div class="well well-lg">
                 <div align="center"><h3>Seleccione Una Presentacion</h3></div> 

                    <table class="table table-bordered">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Nombre</th>
                      <th>Precio</th>
                      <th>Equivalencia</th>
                      <th>Producto Base</th>

                      <th style="width: 40px">Enviar</th>
                    </tr>
                    
                    <tr ng-repeat="row in detPres">
                      <td>@{{$index + 1}}</td>
                      <td ng-hide="true">@{{row.iddetalleP}}</td>
                      <td >@{{row.nombre}}</td>
                      <td>@{{row.precioCompra}}</td>  
                      <td>@{{row.equivalencia}}</td>
                      <td ng-if="row.base==0"><span class="badge bg-red">NO</span></td> 
                      <td ng-if="row.base!=0"><span class="badge bg-green">SI</span></td> 
                      <td><a ng-click="AsignarP(row)" class="btn btn-warning btn-xs" data-dismiss="modal">Enviar</a></td>

                    </tr>
                    
                    
                  </table>
                  
                     
          </div> 
          </div>
        </div>
        </div>
           <!--=---------------------------------------------------------------------=--> 
          <div class="row">
          <!-- capo de Texto  Cantidad-->
          <div class="col-md-1">
          </div> 
            <div class="col-md-2"> 
                <div class="form-group" ng-class="{true: 'has-error'}[ detailPurchaseCreateForm.cantidad.$error.required && detailPurchaseCreateForm.$submitted || detailPurchaseCreateForm.cantidad.$dirty && detailPurchaseCreateForm.cantidad.$invalid]">
                <label for="cantidad">Cantidad</label>
                <input type="number" class="form-control ng-pristine ng-valid ng-touched" name="cantidad" id="cantidad" placeholder="0.00" ng-model="detailPurchase.cantidad" ng-blur="calculateSuppPric()" step="0.1" rquired>
                <label ng-show="detailPurchaseCreateForm.$submitted || detailPurchaseCreateForm.cantidad.$dirty && detailPurchaseCreateForm.cantidad.$invalid">
                  <span ng-show="detailPurchaseCreateForm.cantidad.$error.required"><i class="fa fa-times-circle-o"></i>Requerido.</span>
                </label>
                </div>
            </div>
            <!-- capo de Texto  Precio-->
            <div class="col-md-2">
               <div class="form-group" ng-class="{true: 'has-error'}[ detailPurchaseCreateForm.preCompra.$error.required && detailPurchaseCreateForm.$submitted || detailPurchaseCreateForm.preCompra.$dirty && detailPurchaseCreateForm.preCompra.$invalid]">
                <label for="preCompra">Precio </label>

                <input type="number" class="form-control ng-pristine ng-valid ng-touched" name="preCompra" placeholder="0.00" ng-model="detailPurchase.preCompra" ng-blur="calculateSuppPric()" step="0.1">
                <label ng-show="detailPurchaseCreateForm.$submitted || detailPurchaseCreateForm.preCompra.$dirty && detailPurchaseCreateForm.preCompra.$invalid">
                  <span ng-show="detailPurchaseCreateForm.preCompra.$error.required"><i class="fa fa-times-circle-o"></i>Requerido.</span>
                </label>
                </div>
            </div>

            <!-- capo de Texto  Total Bruto-->
            <div class="col-md-2"> 
                <div class="form-group" ng-class="{true: 'has-error'}[ detailPurchaseCreateForm.montoBruto.$error.required && detailPurchaseCreateForm.$submitted || detailPurchaseCreateForm.montoBruto.$dirty && detailPurchaseCreateForm.montoBruto.$invalid]">
                <label for="montoBruto">Total Bruto</label>
                <input type="number" class="form-control ng-pristine ng-valid ng-touched" name="montoBruto" placeholder="0.00" ng-model="detailPurchase.montoBruto" ng-blur="calculateSuppPric()" step="0.1">
                <label ng-show="detailPurchaseCreateForm.$submitted || detailPurchaseCreateForm.montoBruto.$dirty && detailPurchaseCreateForm.montoBruto.$invalid">
                  <span ng-show="detailPurchaseCreateForm.montoBruto.$error.required"><i class="fa fa-times-circle-o"></i>Requerido.</span>
                </label>
                </div>
            </div>
            <!-- capo de Texto  Descuento-->
            <div class="col-md-2"> 
                <div class="form-group" ng-class="{true: 'has-error'}[ detailPurchaseCreateForm.descuento.$error.required && detailPurchaseCreateForm.$submitted || detailPurchaseCreateForm.descuento.$dirty && detailPurchaseCreateForm.descuento.$invalid]">
                <label for="descuento">Descuento % </label>

                <input type="number" class="form-control ng-pristine ng-valid ng-touched" name="descuento" placeholder="0.00" ng-model="detailPurchase.descuento" ng-blur="calculateSuppPric()" step="0.1">
                <label ng-show="detailPurchaseCreateForm.$submitted || detailPurchaseCreateForm.descuento.$dirty && detailPurchaseCreateForm.descuento.$invalid">
                  <span ng-show="detailPurchaseCreateForm.descuento.$error.required"><i class="fa fa-times-circle-o"></i>Requerido.</span>
                </label>
                </div>
            </div>
            <!-- capo de Texto  Total-->
            <div class="col-md-2"> 
                <div class="form-group" ng-class="{true: 'has-error'}[ detailPurchaseCreateForm.montoTotal.$error.required && detailPurchaseCreateForm.$submitted || detailPurchaseCreateForm.montoTotal.$dirty && detailPurchaseCreateForm.montoTotal.$invalid]">
                <label for="montoTotal">Total</label>
                <input type="number" class="form-control ng-pristine ng-valid ng-touched" name="montoTotal" placeholder="0.00" ng-model="detailPurchase.montoTotal" ng-blur="calculateSuppPric()" step="0.1">
                <label ng-show="detailPurchaseCreateForm.$submitted || detailPurchaseCreateForm.montoTotal.$dirty && detailPurchaseCreateForm.montoTotal.$invalid">
                  <span ng-show="detailPurchaseCreateForm.montoTotal.$error.required"><i class="fa fa-times-circle-o"></i>Requerido.</span>
                </label>
                </div>
            </div>
            </div>
          <div class="row">
          <!-- capo de Texto  Cantidad-->
          <div class="col-md-1">
          </div> 
           <div class="col-md-4">
          <button type="submit" class="btn btn-primary" ng-click="AgregarProducto()">Agregar Producto</button>
          </div>
        </div>
          </form>
        </div><!-- /.box-body -->
      </div>
      <script>
    $("#box-addPro").activateBox();
      </script>
              
  </div>
  
  <!--=======================================================================================================-->
  <div ng-show="show" class="box" name="table_de_detalle">
    <!--==========================================Agregar Producto====================================-->
      <div class="box box-default" id="price">
        <div class="box-header with-border">
          <h3 class="box-title">Lista de Producto</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body" style="display: block;">
          <table class="table table-bordered" id="tabla1">
            <tr>
              <th style="width: 10px">#</th>

              <th>Producto</th>
              <th>Variante </th>
              <th>Cantidad</th>
              <th>Precio Producto</th>
              <th>Precio Compra</th>
              <th>Total Bruto</th>
              <th>Descuento</th>
              <th>SubTotal</th>
              <th>Acciones</th>     
            </tr>
            <tr  ng-repeat="row in detailPurchases " >
                      <td>@{{$index + 1}}</td>
                      <td ng-hide="true">@{{row.orderPurchases_id}}</td>
                      <td ng-hide="true">@{{row.detPres_id}}</td>
                      <td>@{{row.nombre}}</td>
                      <td>@{{row.CodigoPCompra}}</td>
                      <td>@{{row.cantidad}}</td>
                      <td>S/.@{{row.preProducto}}</td>
                      <td>S/.@{{row.preCompra}}</td>
                      <td>S/.@{{row.montoBruto}}</td>
                      <td>@{{row.descuento}}%</td>
                      <td>S/.@{{row.montoTotal}}</td>
                      <!--<td><a data-target="#miventanaEditRow" ng-click="EditarDetalles(row,$index)" data-toggle="modal" class="btn btn-warning btn-xs" ><i class="fa fa-fw fa-pencil"></i></a>
                          <a  class="btn btn-danger btn-xs" ng-click="sacarRow($index,row.montoTotal)"><i class="fa fa-fw fa-trash"></i></a>
                      </td>-->
                       <td><button type="button" class="btn  btn-xs" ng-click="addCant(row,$index)">
                        <span class="glyphicon glyphicon-plus"></span>
                        <button type="button" class="btn btn-xs " ng-disabled="" ng-click="lessCant(row,$index)">
                        <span type="button" class="glyphicon glyphicon-minus"></span><button type="button" class="btn btn-danger btn-xs"  ng-click="sacarRow($index,row.montoTotal)">
                        <span class="glyphicon glyphicon-trash"></span></td>
                      
                      <!--<td><a ng-click="sacarRow(row.index,row.montoTotal)" class="btn btn-warning btn-xs">Sacar</a></td>
                      <td><a ng-click="EditarDetalles(row,row.index)" data-target="#miventanaEditRow" data-toggle="modal" class="btn btn-warning btn-xs">Edit</a></td>
                    -->
                    </tr> 
          </table>
          
<!--===============================================================================================-->
     <div class="row">
          <div class="col-md-4"> 
                <div class="form-group">
                <label for="suppPric">Descuento</label>
                <input type="number" ng-model="orderPurchase.descuento" class="form-control ng-valid ng-dirty ng-valid-number ng-touched" 
                name="descuento" placeholder="0.00"  ng-disabled="product.hasVariants" ng-blur="calcularmontoBrutoF()" step="0.1">
              </div>
            </div>
            <!-- capo de Texto  Descuento-->
            <div class="col-md-4"> 
              <div class="form-group">
                <label for="suppPric">Monto Bruto</label>
                <input type="number" ng-model="orderPurchase.montoBruto" class="form-control ng-valid ng-dirty ng-valid-number ng-touched" 
                name="montoBruto" placeholder="0.00"  ng-disabled="product.hasVariants" ng-blur="calcularmontoBrutoF()" step="0.1">
              </div>
            </div>
            <!-- capo de Texto  Total-->
            <div class="col-md-4"> 
                <div class="form-group">
                <label for="suppPric">Monto Total</label>
                <input type="number" ng-model="orderPurchase.montoTotal" class="form-control ng-valid ng-dirty ng-valid-number ng-touched" 
                name="montoTotal" placeholder="0.00"  ng-disabled="product.hasVariants" ng-blur="calcularmontoBrutoF()" step="0.1">
              </div>
            </div>
      </div>


        
                    <button type="submit" class="btn btn-primary" ng-click="DcreatePurchase()">Crear</button>
                    <a href="/orderPurchases" class="btn btn-danger">Cancelar</a>
                  </div>
      </div>
   </div>   
</form>
</div><!-- /.box -->

</div>

</div>
</div>
  <!-- ==========================================================================================-->
  </div>
        </form>
  </div>
</div>
</div>

</section>