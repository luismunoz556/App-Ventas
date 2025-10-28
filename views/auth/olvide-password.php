<h1 class="nombre-pagina">Olvide mi Password</h1>
<p class="descripcion-pagina">Si has olvidado tu password, te enviaremos un correo para restablecerlo</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>
<form action="/olvide-password" method="POST" class="formulario">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Tu Email">
    </div>
    <input type="submit" value="Enviar Instrucciones" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya Tienes una cuenta? Inicia Sesion</a>    
    <a href="/crear-cuenta">¿Aun No Tienes Cuenta? Crear Cuenta</a>    
</div>