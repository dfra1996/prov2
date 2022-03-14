<?php require_once("controlador/cini.php"); ?>
<div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6"><img style="width:90%; height: 90%;" src="img/indice.jpg"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <H3>INGRESO</H3>
                                    </div>
                                    <form name="frm1" class="user" action="modelo/control.php" method="POST">
                                        <div class="form-group">
                                            <input type="number" class="form-control"
                                                id="exampleInputEmail" name="usu" aria-describedby="emailHelp"
                                                placeholder="Ingrese # de Cedula">
                                        </div>
                                        <hr>  
                                         <?php erroraute(); ?>  
                                        <div class="d-flex justify-content-center">
                                            <input type="submit" class="btn btn-warning" value="INGRESAR">
                                        </div>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>