<?php
// filepath: template-parts/panel-parts/templates.php
// Panel de selección directa de plantillas (grid de miniaturas)
$mytemplates = PalleonSettings::get_option('allow_json','enable'); 
$perpage = PalleonSettings::get_option('tp_pagination',21);  
$myperpage = PalleonSettings::get_option('mytp_pagination',10);

// Verificar módulo habilitado
if (PalleonSettings::get_option('module_templates', 'enable') === 'enable'):
    // Obtener paginación
    $perpage = PalleonSettings::get_option('tp_pagination', 21);
?>

<!-- CÓDIGO HARDCODEADO PARA PRUEBAS -->
<div id="palleon-templates" class="palleon-icon-panel-content panel-hide">
<div class="palleon-tabs">
                            <ul class="palleon-tabs-menu" style="margin: 0px 0 61px;">
                                <li class="active" data-target="#palleon-all-templates">All</li>
                                <?php if (is_user_logged_in()) { ?>
                                <li data-target="#palleon-templates-favorites">My Favorites</li>
                                <?php } ?>
                                <?php if ($mytemplates == 'enable' && is_user_logged_in()) { ?>
                                <li data-target="#palleon-my-templates-tab">My Templates</li>
                                <?php } ?>
                            </ul>
                            <div id="palleon-all-templates" class="palleon-tab active">
                                <div class="palleon-templates-menu-wrap">
                                    <input id="palleon-template-search-keyword" type="search" class="palleon-form-field" placeholder="Search by keyword..." autocomplete="off" />
                                    <select id="palleon-templates-menu" class="palleon-select palleon-select2" autocomplete="off">
                                        <option value="all" selected>All Tags (12)</option>
                                        <option value="business">Business (5)</option>
                                        <option value="social">Social Media (4)</option>
                                        <option value="marketing">Marketing (4)</option>
                                        <option value="creative">Creative (4)</option>
                                        <option value="education">Education (2)</option>
                                        <option value="template">Template (2)</option>
                                        <option value="design">Design (3)</option>
                                    </select>
                                    <button id="palleon-template-search" type="button" class="palleon-btn primary"><span class="material-icons">search</span></button>
                                </div>
                                <div class="palleon-templates-content">
                                    <div class="palleon-grid-wrap">
                                        <div id="palleon-templates-grid" class="palleon-grid template-grid template-selection paginated" data-perpage="21">
                                            <!-- Los templates se cargarán dinámicamente vía AJAX -->
                                        </div>
                                    </div>
                                    <!-- Contenedor de paginación dinámico (inicialmente oculto) -->
                                    <div id="templates-pagination" class="palleon-pagination-wrap" style="display: none;">
                                        <!-- La paginación se generará dinámicamente aquí -->
                                    </div>
                                </div>
                            </div>
                            <?php if (is_user_logged_in()) { ?>
                            <div id="palleon-templates-favorites" class="palleon-tab">
                                <div id="palleon-templates-favorites-grid" class="palleon-grid template-grid template-selection paginated" data-perpage="21">
                                    <div class="notice notice-info"><h6>No favorites yet</h6>Click the star icon on any template, and you will see it here next time you visit.</div>
                                </div>
                            </div>
                            <?php } ?>
                    <?php if ($mytemplates == 'enable' && is_user_logged_in()) { ?>
                    <div id="palleon-my-templates-tab" class="palleon-tab">
                    <div id="palleon-my-templates-menu">
                        <div class="palleon-search-box">
                            <input type="search" class="palleon-form-field" placeholder="Search by title..." autocomplete="off" />
                            <button id="palleon-my-templates-search" type="button" class="palleon-btn primary"><span class="material-icons">search</span></button>
                        </div>
                    </div>
                    <ul id="palleon-my-templates" class="palleon-template-list template-selection paginated" data-perpage="<?php echo esc_attr($myperpage); ?>"></ul>
                    <div id="palleon-my-templates-noimg" class="notice notice-warning d-none">Nothing found.</div>
                </div>    
                <?php } ?>
                </div>
</div>
<!-- FIN CÓDIGO HARDCODEADO PARA PRUEBAS -->

<style>
/* Estilos para la paginación */
.palleon-pagination {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin: 20px 0;
    gap: 8px;
}

.palleon-pagination a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 35px;
    height: 35px;
    padding: 8px 12px;
    text-decoration: none;
    border: 1px solid #ddd;
    background: #fff;
    color: #333;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.palleon-pagination a:hover {
    background: #f5f5f5;
    border-color: #007cba;
}

.palleon-pagination a.current {
    background: #007cba;
    color: #fff;
    border-color: #007cba;
}

.palleon-pagination a.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}

.palleon-pagination .material-icons {
    font-size: 18px;
}

/* Alineación horizontal para elementos de paginación dinámica */
.palleon-pagination-numbers {
    display: flex;
    gap: 3px;
    align-items: center;
    justify-content: center;
    width: 100%;
}

.palleon-pagination-navigation {
    display: flex;
    width: 100%;
    gap: 8px;
    margin-top: 8px;
}



.palleon-pagination-btn {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    min-width: 35px;
    height: 35px;
    padding: 8px 12px;
    text-decoration: none;
    border-radius: 4px;
    transition: all 0.3s ease;
}


.palleon-pagination-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
}

.palleon-pagination-dots {
    display: inline-flex;
    align-items: center;
    font-size: 13px;
    padding: 0 2px;
}
</style>

                <?php endif; ?>

<script>
jQuery(document).ready(function($) {
    'use strict';
    
    // Variables globales
    let templatesData = [];
    let currentFilter = 'all';
    let currentKeyword = '';
    let isLoading = false;
    
    console.log('🚀 Sistema de templates iniciado');
    
    // Función para cargar templates vía AJAX
    function loadTemplatesViaAjax() {
        console.log('📡 Iniciando carga de templates via AJAX...');
        
        if (isLoading) {
            console.log('⚠️ Ya hay una carga en progreso, saltando...');
            return;
        }
        
        const templatesGrid = $('#palleon-templates-grid');
        if (!templatesGrid.length) {
            console.error('❌ Grid de templates no encontrado (#palleon-templates-grid)');
            return;
        }
        
        console.log('✅ Grid encontrado, elementos:', templatesGrid.length);
        
        isLoading = true;
        
        // Mostrar loader
        templatesGrid.html('<div class="palleon-templates-loader"><div class="palleon-loader"></div><p>Cargando templates...</p></div>');
        
        // Obtener dimensiones del canvas
        const canvasWidth = window.palleonWidth || 1200;
        const canvasHeight = window.palleonHeight || 800;
        
        console.log('📏 Dimensiones del canvas:', canvasWidth + 'x' + canvasHeight);
        
        // Preparar datos para AJAX
        const ajaxData = {
            action: 'templateSearchJson',
            nonce: palleon.nonce,
            query: currentKeyword,
            width: canvasWidth,
            height: canvasHeight
        };
        
        console.log('📤 Datos de AJAX:', ajaxData);
        
        // Realizar petición AJAX
        $.ajax({
            url: palleon.ajaxurl,
            type: 'POST',
            data: ajaxData,
            dataType: 'json',
            timeout: 10000,
            success: function(response) {
                console.log('📥 Respuesta del servidor:', response);
                
                if (response.success && response.data && response.data.templates) {
                    console.log('✅ Templates recibidos:', response.data.templates.length);
                    console.log('🔍 Primer template:', response.data.templates[0]);
                    
                    templatesData = response.data.templates;
                    renderTemplates();
                    
                    // Inicializar lazy loading
                    if ($.fn.lazyload) {
                        console.log('🖼️ Inicializando lazy loading...');
                        $('.lazy').lazyload({
                            threshold: 200,
                            effect: 'fadeIn'
                        });
                    }
                } else {
                    console.error('❌ Respuesta inválida:', response);
                    templatesGrid.html('<div class="palleon-no-templates">No se encontraron templates</div>');
                }
                
                isLoading = false;
            },
            error: function(xhr, status, error) {
                console.error('❌ Error en AJAX:', {
                    status: status,
                    error: error,
                    responseText: xhr.responseText
                });
                templatesGrid.html('<div class="palleon-no-templates">Error al cargar templates: ' + error + '</div>');
                isLoading = false;
            }
        });
    }
    
    // Función para renderizar templates
    function renderTemplates() {
        console.log('🎨 Iniciando renderizado de templates...');
        console.log('📊 Templates disponibles:', templatesData.length);
        console.log('🔍 Filtro actual:', currentFilter);
        console.log('🔎 Keyword actual:', currentKeyword);
        
        const templatesGrid = $('#palleon-templates-grid');
        let filteredTemplates = templatesData;
        
        // Aplicar filtro de categoría
        if (currentFilter !== 'all') {
            const beforeFilter = filteredTemplates.length;
            if (currentFilter === 'favorites') {
                filteredTemplates = templatesData.filter(template => template.favorited);
            } else {
                filteredTemplates = templatesData.filter(template => 
                    template.tags && template.tags.includes(currentFilter)
                );
            }
            console.log(`🏷️ Filtro de categoría (${currentFilter}): ${beforeFilter} → ${filteredTemplates.length}`);
        }
        
        // Aplicar filtro de búsqueda
        if (currentKeyword) {
            const beforeFilter = filteredTemplates.length;
            filteredTemplates = filteredTemplates.filter(template =>
                template.title.toLowerCase().includes(currentKeyword.toLowerCase()) ||
                (template.tags && template.tags.toLowerCase().includes(currentKeyword.toLowerCase()))
            );
            console.log(`🔍 Filtro de búsqueda (${currentKeyword}): ${beforeFilter} → ${filteredTemplates.length}`);
        }
        
        // Limitar a 6 resultados
        const beforeLimit = filteredTemplates.length;
        filteredTemplates = filteredTemplates.slice(0, 6);
        console.log(`✂️ Límite de 6: ${beforeLimit} → ${filteredTemplates.length}`);
        
        // Construir HTML
        let templatesHTML = '';
        filteredTemplates.forEach((template, index) => {
            console.log(`🔧 Construyendo template ${index + 1}:`, template);
            const templateHTML = buildTemplateHTML(template);
            console.log(`📝 HTML generado para template ${index + 1}:`, templateHTML.substring(0, 100) + '...');
            templatesHTML += templateHTML;
        });
        
        console.log('📄 HTML total length:', templatesHTML.length);
        
        // Insertar en el DOM
        templatesGrid.html(templatesHTML);
        console.log('✅ HTML insertado en el DOM');
        
        // Verificar que se insertó correctamente
        const insertedItems = templatesGrid.find('.grid-item');
        console.log(`🔍 Elementos .grid-item encontrados después de insertar: ${insertedItems.length}`);
        
        console.log(`🎉 Renderizado completo: ${filteredTemplates.length} templates`);
    }
    
    // Función para construir HTML de un template
    function buildTemplateHTML(template) {
        console.log('🏗️ Construyendo HTML para template:', template.title);
        
        // Validar datos del template
        if (!template.id || !template.title || !template.preview || !template.json) {
            console.error('❌ Template con datos incompletos:', template);
            return '<div class="grid-item error">Template con datos incompletos</div>';
        }
        
        const favoriteIcon = template.favorited ? 'star' : 'star_border';
        const tags = template.tags || '';
        const version = template.version || 'free';
        
        console.log('📋 Datos del template:', {
            id: template.id,
            title: template.title,
            preview: template.preview,
            json: template.json,
            tags: tags,
            version: version,
            favorited: template.favorited
        });
        
        const html = `
            <div class="grid-item" data-tags="${tags}">
                <div class="template-favorite">
                    <button type="button" class="palleon-btn-simple star" data-templateid="${template.id}">
                        <span class="material-icons">${favoriteIcon}</span>
                    </button>
                </div>
                <div class="palleon-masonry-item-inner palleon-select-template" 
                     data-json="${template.json}" 
                     data-version="${version}">
                    <div class="palleon-img-wrap">
                        <div class="palleon-img-loader"></div>
                        <img class="lazy" 
                             data-src="${template.preview}" 
                             data-title="${template.title}" 
                             data-preview="${template.preview}" 
                             alt="${template.title}" />
                    </div>
                    <div class="palleon-masonry-item-desc">
                        ${template.title}
                    </div>
                </div>
            </div>
        `;
        
        console.log('✅ HTML construido para:', template.title);
        return html;
    }
    
    // Event handlers para filtros
    $('#palleon-templates-menu ul li').on('click', function(e) {
        e.preventDefault();
        
        const target = $(this).data('target');
        console.log('🔄 Filtro seleccionado:', target);
        
        // Actualizar estado activo
        $('#palleon-templates-menu ul li').removeClass('active');
        $(this).addClass('active');
        
        // Aplicar filtro
        currentFilter = target;
        
        if (templatesData.length > 0) {
            renderTemplates();
        } else {
            console.log('⚠️ No hay templates cargados, cargando...');
            loadTemplatesViaAjax();
        }
    });
    
    // Event handler para búsqueda
    $('#palleon-template-search').on('click', function() {
        const keyword = $('#palleon-template-search-keyword').val();
        console.log('🔍 Búsqueda por botón:', keyword);
        
        currentKeyword = keyword;
        
        if (templatesData.length > 0) {
            renderTemplates();
        } else {
            loadTemplatesViaAjax();
        }
    });
    
    // Event handler para búsqueda en tiempo real
    $('#palleon-template-search-keyword').on('input', function() {
        const keyword = $(this).val();
        
        if (keyword.length === 0 || keyword.length >= 3) {
            console.log('🔍 Búsqueda en tiempo real:', keyword);
            currentKeyword = keyword;
            
            if (templatesData.length > 0) {
                renderTemplates();
            } else {
                loadTemplatesViaAjax();
            }
        }
    });
    
    // Event handler para Enter en búsqueda
    $('#palleon-template-search-keyword').on('keypress', function(e) {
        if (e.which === 13) {
            const keyword = $(this).val();
            console.log('🔍 Búsqueda con Enter:', keyword);
            currentKeyword = keyword;
            
            if (templatesData.length > 0) {
                renderTemplates();
            } else {
                loadTemplatesViaAjax();
            }
        }
    });
    
    // Event handler para favoritos
    $(document).on('click', '.template-favorite .star', function() {
        const templateId = $(this).data('templateid');
        const icon = $(this).find('.material-icons');
        
        console.log('⭐ Toggle favorito para:', templateId);
        
        // Toggle favorito
        if (icon.text() === 'star_border') {
            icon.text('star');
            // Aquí podrías agregar lógica para guardar en BD
        } else {
            icon.text('star_border');
            // Aquí podrías agregar lógica para remover de BD
        }
        
        // Actualizar datos locales
        const template = templatesData.find(t => t.id === templateId);
        if (template) {
            template.favorited = !template.favorited;
            console.log('📊 Template actualizado:', template);
        }
        
        // Re-renderizar si estamos en filtro de favoritos
        if (currentFilter === 'favorites') {
            renderTemplates();
        }
    });
    
    // Función para detectar cuando se abre el panel de templates
    function setupTemplatesPanelDetection() {
        console.log('🔍 Configurando detección de panel de templates...');
        
        const templatesTab = $('[data-target="palleon-panel-templates"]');
        console.log('🎯 Tab de templates encontrado:', templatesTab.length);
        
        if (templatesTab.length) {
            templatesTab.on('click', function() {
                console.log('👆 Click en tab de templates');
                setTimeout(function() {
                    const gridVisible = $('#palleon-templates-grid').is(':visible');
                    console.log('👁️ Grid visible:', gridVisible);
                    console.log('📊 Templates cargados:', templatesData.length);
                    
                    if (gridVisible && templatesData.length === 0) {
                        console.log('🔄 Cargando templates por click en tab...');
                        loadTemplatesViaAjax();
                    }
                }, 100);
            });
        }
        
        // También cargar si el panel ya está visible
        const gridVisible = $('#palleon-templates-grid').is(':visible');
        console.log('👁️ Grid visible al inicio:', gridVisible);
        
        if (gridVisible) {
            console.log('🔄 Cargando templates porque el grid ya está visible...');
            loadTemplatesViaAjax();
        }
    }
    
    // Función de inicialización con retry
    function initializeWithRetry() {
        console.log('🔄 Intentando inicializar...');
        
        if ($('#palleon-templates-grid').length) {
            console.log('✅ Grid encontrado, inicializando...');
            setupTemplatesPanelDetection();
            
            // Cargar templates inmediatamente si el grid está visible
            if ($('#palleon-templates-grid').is(':visible')) {
                console.log('🔄 Grid visible, cargando templates inmediatamente...');
                loadTemplatesViaAjax();
            }
        } else {
            console.log('⚠️ Grid no encontrado, reintentando en 1 segundo...');
            setTimeout(initializeWithRetry, 1000);
        }
    }
    
    // Inicialización
    initializeWithRetry();
    
    // Botón de debug
    if (console && console.log) {
        $('body').append('<button id="debug-templates" style="position:fixed;top:10px;left:10px;z-index:9999;background:red;color:white;padding:5px;border:none;border-radius:3px;">Debug Templates</button>');
        
        $('#debug-templates').on('click', function() {
            console.log('🐛 DEBUG INFO:');
            console.log('Grid existe:', $('#palleon-templates-grid').length);
            console.log('Grid visible:', $('#palleon-templates-grid').is(':visible'));
            console.log('Templates cargados:', templatesData.length);
            console.log('Filtro actual:', currentFilter);
            console.log('Keyword actual:', currentKeyword);
            console.log('Está cargando:', isLoading);
            console.log('Templates data:', templatesData);
            
            // Forzar carga
            if (templatesData.length === 0) {
                console.log('🔄 Forzando carga de templates...');
                loadTemplatesViaAjax();
            }
        });
    }
    
    console.log('🎉 Sistema de templates AJAX inicializado completamente');
});
</script>
