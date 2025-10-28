// Menú móvil
document.addEventListener('DOMContentLoaded', function() {
    console.log('JavaScript cargado correctamente');
    
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenuDropdown = document.getElementById('mobile-menu-dropdown');
    
    console.log('Botón encontrado:', mobileMenuBtn);
    console.log('Dropdown encontrado:', mobileMenuDropdown);
    
    if (mobileMenuBtn && mobileMenuDropdown) {
        console.log('Agregando event listeners');
        
        // Toggle del menú móvil
        mobileMenuBtn.addEventListener('click', function(e) {
            console.log('Click en botón hamburguesa');
            e.stopPropagation();
            mobileMenuDropdown.classList.toggle('active');
            console.log('Clase active toggleada');
        });
        
        // Cerrar menú al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (!mobileMenuBtn.contains(e.target) && !mobileMenuDropdown.contains(e.target)) {
                mobileMenuDropdown.classList.remove('active');
            }
        });
        
        // Cerrar menú al hacer clic en un enlace
        const mobileNavItems = mobileMenuDropdown.querySelectorAll('.mobile-nav-item');
        mobileNavItems.forEach(item => {
            item.addEventListener('click', function() {
                mobileMenuDropdown.classList.remove('active');
            });
        });
        
        // Prevenir que el clic en el menú lo cierre
        mobileMenuDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    } else {
        console.log('No se encontraron los elementos del menú móvil');
    }
});
