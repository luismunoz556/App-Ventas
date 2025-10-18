<h1 class="nombre-pagina">Crear Cuenta  </h1>
<p class="descripcion-pagina">Crea Tu Cuenta En La Plataforma</p>


<?php include_once __DIR__ . '/../templates/alertas.php'; ?>
<form action="/crear-cuenta" method="POST" class="formulario">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="NOMBRE" placeholder="Tu Nombre" value="<?php echo $usuario->NOMBRE; ?>">
    </div>

    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="APELLIDO" placeholder="Tu Apellido" value="<?php echo $usuario->APELLIDO; ?>">
    </div>

    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="tel" id="telefono" name="TELEFONO" placeholder="Tu Telefono" value="<?php echo $usuario->TELEFONO; ?>">
    </div>

    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="EMAIL" placeholder="Tu Email" value="<?php echo $usuario->EMAIL; ?>">
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="PASSWORD" placeholder="Tu Password" >
    </div>

    <input type="submit" value="Crear Cuenta" class="boton">
</form>

<div class="acciones">
    <a href="/">Ya Tienes una cuenta? Inicia Sesion</a>    
    <a href="/olvide-password">Olvidaste Tu Password?</a>    
</div>