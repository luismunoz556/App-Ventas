<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia Sesion Con Tu Cuenta</p>

<form action="/" method="POST" class="formulario">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Tu Email">
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Tu Password">
    </div>
    <input type="submit" value="Iniciar Sesion" class="boton">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aun No Tienes Cuenta? Crear Cuenta</a>    
    <a href="/olvide-password">Olvidaste Tu Password?</a>    
</div>