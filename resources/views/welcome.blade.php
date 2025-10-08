<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JF Products SAS - Soluciones Médicas Confiables</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Articulat+CF:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Omnes:wght@300;400;500;600;700&display=swap">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <style>
        body { font-family: 'Omnes', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Articulat CF', sans-serif; }
        .btn-primary { background-color: #0f4db3; }
        .btn-primary:hover { background-color: #0c3e90; }
        .btn-secondary { background-color: #028dff; }
        .btn-secondary:hover { background-color: #017ae0; }
        .logo-container { width: 150px; height: auto; }
        .hero-bg {
            background: linear-gradient(135deg, rgba(15, 77, 179, 0.5), rgba(2, 141, 255, 0.4)), 
                        url('img/banner.png');
            background-size: cover;
            background-position: center;
            transition: background-image 0.5s ease-in-out;
            position: relative;
        }

        .hero-bg:hover {
            background-image: linear-gradient(135deg, rgba(15, 77, 179, 0.2), rgba(2, 141, 255, 0.1)),
                              url('img/banner.png');
        }

        .hero-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0);
            transition: background-color 0.5s ease-in-out;
        }

        .hero-bg:hover::before {
            background-color: rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="bg-gray-50">
    <header class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <img src="img/logoNavbar.jpg" alt="Logo JF Products SAS" class="logo-container">
                </div>

                <nav class="hidden md:flex space-x-8">
                    <a href="#inicio" class="text-gray-700 hover:text-[#028dff] font-medium transition">Inicio</a>
                    <a href="#quienes-somos" class="text-gray-700 hover:text-[#028dff] font-medium transition">Quiénes Somos</a>
                    <a href="#productos" class="text-gray-700 hover:text-[#028dff] font-medium transition">Productos</a>
                    <a href="#comisiona" class="text-gray-700 hover:text-[#028dff] font-medium transition">Comisiona</a>
                    <a href="#contacto" class="text-gray-700 hover:text-[#028dff] font-medium transition">Contacto</a>
                </nav>
                
                <div class="flex items-center space-x-6 hidden md:flex">
                    <a href="{{ route('login') }}" class="text-[#0f4db3] font-semibold transition">
                        Portal Clientes
                    </a>
                    <a href="#contacto" class="btn-primary text-white px-6 py-2 rounded-lg font-semibold transition">
                        Contáctanos
                    </a>
                </div>

                <button class="md:hidden text-gray-700" onclick="toggleMobileMenu()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            
            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4">
                <div class="flex flex-col space-y-3">
                    <a href="#inicio" class="text-gray-700 hover:text-[#028dff] font-medium">Inicio</a>
                    <a href="#quienes-somos" class="text-gray-700 hover:text-[#028dff] font-medium">Quiénes Somos</a>
                    <a href="#productos" class="text-gray-700 hover:text-[#028dff] font-medium">Productos</a>
                    <a href="#comisiona" class="text-gray-700 hover:text-[#028dff] font-medium">Comisiona</a>
                    <a href="#contacto" class="text-gray-700 hover:text-[#028dff] font-medium">Contacto</a>
                    <a href="{{ route('login') }}" class="text-[#0f4db3] font-semibold transition">
                        Portal Clientes
                    </a>
                </div>
            </div>
        </div>
    </header>

    <section id="inicio" class="hero-bg text-white py-20 lg:py-32">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl lg:text-6xl font-bold mb-6">
                Soluciones confiables para el sector salud
            </h2>
            <p class="text-xl lg:text-2xl mb-8 max-w-3xl mx-auto opacity-90">
                Distribuimos insumos y medicamentos de uso institucional. Todos los productos que comercializamos cumplen con la normatividad aplicable en Colombia a través de sus fabricantes y distribuidores autorizados.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#productos" class="btn-primary text-white px-8 py-4 rounded-lg font-semibold text-lg transition">
                    Ver Productos
                </a>
                <a href="#contacto" class="btn-secondary text-white px-8 py-4 rounded-lg font-semibold text-lg transition">
                    Contáctanos
                </a>
            </div>
        </div>
    </section>

    <section id="productos" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h3 class="text-4xl font-bold text-gray-800 mb-4">Nuestros Productos</h3>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Ofrecemos una amplia gama de productos médicos de la más alta calidad
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <div class="card-hover bg-gradient-to-br from-[#9cd1fe] to-[#e6f1fe] p-8 rounded-2xl border border-[#9cd1fe]">
                    <div class="w-16 h-16 bg-[#0f4db3] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-800 mb-4">Medicamentos</h4>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Amplio catálogo de medicamentos genéricos y de marca, todos con registro sanitario vigente y almacenamiento bajo estrictas normas de calidad.
                    </p>
                    <a href="#" class="btn-primary inline-block text-white px-6 py-3 rounded-lg font-semibold transition">
                        Más Información
                    </a>
                </div>
                
                <div class="card-hover bg-gradient-to-br from-[#e6f1fe] to-[#9cd1fe] p-8 rounded-2xl border border-[#9cd1fe]">
                    <div class="w-16 h-16 bg-[#028dff] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                        </svg>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-800 mb-4">Insumos Médicos</h4>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Dispositivos médicos, material quirúrgico, equipos de protección personal y todo lo necesario para centros de salud y consultorios.
                    </p>
                    <a href="#" class="btn-primary inline-block text-white px-6 py-3 rounded-lg font-semibold transition">
                        Más Información
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <section id="quienes-somos" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h3 class="text-4xl font-bold text-gray-800 mb-4">Quiénes Somos</h3>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    JF Products SAS es una empresa colombiana especializada en la distribución de medicamentos e insumos médicos, con sede en Barranquilla. Nos dedicamos a brindar soluciones integrales al sector salud con los más altos estándares de calidad.
                </p>
            </div>
            
            <div class="grid lg:grid-cols-2 gap-8 mb-16">
                <div class="bg-white p-8 rounded-2xl shadow-lg border-l-4 border-[#028dff]">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#028dff] rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                        <h4 class="text-2xl font-bold text-[#0f4db3]">Misión</h4>
                    </div>
                    <p class="text-gray-700 leading-relaxed text-lg">
                        Ofrecer una distribución eficiente y segura de medicamentos e insumos médicos. Nos comprometemos a operar con los más altos estándares de ética y servicio, con un personal altamente capacitado dispuesto a colaborar estrechamente con nuestros socios para satisfacer las necesidades del sector salud de manera confiable y sostenible.
                    </p>
                </div>
                
                <div class="bg-white p-8 rounded-2xl shadow-lg border-l-4 border-[#0f4db3]">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#0f4db3] rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <h4 class="text-2xl font-bold text-[#0f4db3]">Visión</h4>
                    </div>
                    <p class="text-gray-700 leading-relaxed text-lg">
                        Ser el líder en distribución de medicamentos e insumos médicos, reconocido por nuestra excelencia en eficiencia, seguridad y ética mediante el desarrollo de unidades de negocio innovadoras. Buscamos transformar continuamente nuestros procesos y fortalecer nuestras alianzas con socios estratégicos para impulsar un sistema de salud más accesible y efectivo.
                    </p>
                </div>
            </div>

            <div class="bg-blue-50 p-6 rounded-lg text-sm text-gray-700 mt-10 border-l-4 border-blue-400">
                <p>
                    <span class="font-semibold">Aviso de Responsabilidad:</span> JF Products SAS actúa como distribuidor institucional. La responsabilidad de los registros sanitarios y autorizaciones corresponde a los fabricantes y proveedores aliados. Estamos en proceso de consolidar nuestras certificaciones y autorizaciones ante las autoridades competentes.
                </p>
            </div>
            
        </div>
    </section>
    
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h3 class="text-4xl font-bold text-gray-800 mb-4">Compromiso con la Calidad</h3>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <div class="text-center bg-white p-6 rounded-2xl shadow-lg card-hover">
                    <div class="w-16 h-16 bg-[#0f4db3] rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <p class="text-gray-600 mb-2">
                        Todos nuestros productos se adquieren a proveedores debidamente autorizados.
                    </p>
                </div>
                
                <div class="text-center bg-white p-6 rounded-2xl shadow-lg card-hover">
                    <div class="w-16 h-16 bg-[#028dff] rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-gray-600 mb-2">
                        Estamos en proceso de obtener o actualizar nuestras habilitaciones correspondientes.
                    </p>
                </div>
                
                <div class="text-center bg-white p-6 rounded-2xl shadow-lg card-hover">
                    <div class="w-16 h-16 bg-[#0f4db3] rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <p class="text-gray-600 mb-2">
                        Cumplimos las normas de almacenamiento, transporte y buenas prácticas.
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <section id="comisiona" class="py-20 bg-gradient-to-br from-[#0f4db3] to-[#028dff] text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h3 class="text-4xl font-bold mb-6">Comisiona con Nosotros</h3>
                <p class="text-xl mb-12 opacity-90">
                    Únete a nuestro programa de comisionistas y recibe beneficios por recomendar nuestros productos. 
                    Gana dinero extra mientras ayudas a mejorar la salud de tu comunidad.
                </p>
                
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 max-w-2xl mx-auto">
                    <h4 class="text-2xl font-bold mb-6">Solicita Información</h4>
                    <form action="https://formspree.io/f/xjkezedy" method="POST" class="space-y-6" id="comisiona-form">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium mb-2">Nombre Completo</label>
                                <input type="text" name="nombre" required class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50" placeholder="Tu nombre completo">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Teléfono</label>
                                <input type="tel" name="telefono" required class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50" placeholder="Tu número de teléfono">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Correo Electrónico</label>
                            <input type="email" name="email" required class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50" placeholder="tu@email.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Experiencia en el Sector</label>
                            <textarea rows="3" name="experiencia" class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50" placeholder="Cuéntanos sobre tu experiencia en el sector salud..."></textarea>
                        </div>
                        <button type="submit" class="w-full btn-secondary text-white px-8 py-4 rounded-lg font-semibold text-lg transition">
                            Enviar Solicitud
                        </button>
                    </form>
                    <div id="comisiona-status" class="mt-4 text-center"></div>
                </div>
            </div>
        </div>
    </section>
    
    <section id="contacto" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h3 class="text-4xl font-bold text-gray-800 mb-4">Contáctanos</h3>
                <p class="text-xl text-gray-600">Estamos aquí para atenderte</p>
            </div>
            
            <div class="grid lg:grid-cols-2 gap-12">
                <div>
                    <div class="space-y-8">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-[#0f4db3] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-800 mb-2">Teléfono</h4>
                                <p class="text-gray-600">+57 (5) 302 649 5827</p>
                                <p class="text-gray-600">+57 300 123 4567</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-[#028dff] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-800 mb-2">Correo Electrónico</h4>
                                <p class="text-gray-600">comercial@jfproductssas.com </p>
                                <p class="text-gray-600">administrativo@jfproductssas.com </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-[#0f4db3] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-800 mb-2">Dirección</h4>
                                <p class="text-gray-600">Cra 15c # 45c - 06 , Barrio Cevillar</p>
                                <p class="text-gray-600">Barranquilla, Atlántico, Colombia</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-[#028dff] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-800 mb-2">Horario de Atención</h4>
                                <p class="text-gray-600">Lunes a Viernes: 8:00 AM - 6:00 PM</p>
                                <p class="text-gray-600">Sábados: 8:00 AM - 12:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-lg">
                    <h4 class="text-2xl font-bold text-gray-800 mb-6">Envíanos un Mensaje</h4>
                    <form id="contact-form" class="space-y-6" action="https://formspree.io/f/xovnbwrk" method="POST">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                                <input type="text" name="nombre" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0f4db3]" placeholder="Tu nombre">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                                <input type="tel" name="telefono" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0f4db3]" placeholder="Tu teléfono">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0f4db3]" placeholder="tu@email.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mensaje</label>
                            <textarea rows="4" name="mensaje" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0f4db3]" placeholder="¿En qué podemos ayudarte?"></textarea>
                        </div>

                        <input type="hidden" name="_subject" value="Nuevo mensaje desde JF Products SAS">
                        <input type="hidden" name="_next" value="https://tu-dominio.com/gracias.html">
                        <input type="hidden" name="_captcha" value="false">
                        <button type="submit" class="w-full btn-primary text-white px-8 py-4 rounded-lg font-semibold text-lg transition">
                            Enviar Mensaje
                        </button>
                    </form>
                    <div id="contact-status" class="mt-4 text-center"></div>
                </div>
            </div>
        </div>
    </section>
    
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-6">
                        <img src="img/imgFooter.png" alt="Logo JF Products SAS" class="w-40 h-auto">
                    </div>
                    <p class="text-gray-400 mb-4">
                        Soluciones confiables para el sector salud en Barranquilla, Colombia.
                    </p>
                    <p class="text-gray-400 text-sm">
                        Razón Social: JF Products SAS<br>
                        NIT: 900.XXX.XXX-X<br>
                        Dirección: Cra 15c # 45c - 06, Barrio Cevillar
                    </p>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Enlaces Útiles</h4>
                    <ul class="space-y-2">
                        <li><a href="#inicio" class="text-gray-400 hover:text-white transition">Inicio</a></li>
                        <li><a href="#productos" class="text-gray-400 hover:text-white transition">Productos</a></li>
                        <li><a href="#quienes-somos" class="text-gray-400 hover:text-white transition">Quiénes Somos</a></li>
                        <li><a href="#comisiona" class="text-gray-400 hover:text-white transition">Comisiona</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Política de Privacidad</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Términos y Condiciones</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Política de Cookies</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contacto Rápido</h4>
                    <div class="space-y-3">
                        <a href="https://wa.me/573026495827" class="flex items-center space-x-3 text-gray-400 hover:text-green-400 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                            <span>WhatsApp</span>
                        </a>
                        <a href="tel:+573026495827" class="flex items-center space-x-3 text-gray-400 hover:text-[#028dff] transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4