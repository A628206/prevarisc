<?php

    class Application_Layout_Helper_Footer extends Zend_Controller_Action_Helper_Abstract
    {
        public function footer()
        {
            ?>

            <div id='layout-footer' class='container_16' >

                <div class='grid_16'>

                    <p id='layout-footer-anchor'><a href='#'>Retour en haut</a></p>

                    <hr />

                    <p id='layout-footer-images'>
                        <img src='/images/favicon.ico' alt='Prevarisc' height=16 width=16 /> ® 2011
                        <a href='http://www.interieur.gouv.fr' >Ministère de l'intérieur</a> -
                        <a href='http://www.sdis62.fr' >SDIS 62</a>.
                        Tous droits réservés.
                    </p>

                    <p id='layout-footer-copyright'>
                        <strong>Prevarisc <span style='font-size: 0.8em'>version finale 1.0.0</span></strong> | <a href='/index/about?format=html' id='layout-footer-copyright-about' >A propos</a>
                    </p>

                </div>

                <script type="text/javascript">

                    // Boite de dialogue
                    $('a#layout-footer-copyright-about').fancybox({
                        autoDimensions: false,
                        height: 460,
                        width: 800
                    });

                    // Vérification pérdiodique de la validité de la session utilisateur
                    function checkActive()
                    {
                        $.ajax({

                            url: "/user/is-active?format=json",
                            type: "GET",
                            data: "uid=<?php echo Zend_Auth::getInstance()->getIdentity()->ID_UTILISATEUR ?>",
                            success: function(result) {
                                if (result.active != 1) {
                                    window.location = "/user/logout/deactivated/1";
                                }
                            }
                        });
                    }

                    // checkActive();
                    // window.setInterval("checkActive()", 60000);

                    $('a[title]').tipsy({live: true});

                </script>

            </div>

            <?php
        }

    }
