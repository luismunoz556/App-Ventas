<h1 class="nombre-pagina">Reestablecer mi Password</h1>
<p class="descripcion-pagina">Digita tu nuevo password</p>
<?php include_once __DIR__ . '/../templates/alertas.php'; ?>
<?php if($error) return; ?>
<form  method="POST" class="formulario">
    <div class="campo">
        <label for="password">Nuevo Password</label>
        <input type="password" id="password" name="password" placeholder="Tu Nuevo Password">
    </div>
    <input type="submit" value="Reestablecer Password" class="boton">
</form>
<div class="acciones">
    <a href="/">¿Ya Tienes una cuenta? Inicia Sesion</a>    
    <a href="/crear-cuenta">¿Aun No Tienes Cuenta? Crear Cuenta</a>    
</div>