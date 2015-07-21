<?php

	namespace KMS\FroalaEditorBundle\DependencyInjection;

	use Symfony\Component\Config\FileLocator;
	use Symfony\Component\DependencyInjection\ContainerBuilder;
	use Symfony\Component\DependencyInjection\Loader;
	use Symfony\Component\HttpKernel\DependencyInjection\Extension;

	/**
	 * KMS Froala extension.
	 * Class KMSFroalaEditorExtension
	 * @package KMS\FroalaEditorBundle\DependencyInjection
	 */
	class KMSFroalaEditorExtension extends Extension
	{

		// -------------------------------------------------------------//
		// --------------------------- METHODS -------------------------//
		// -------------------------------------------------------------//

		/**
		 * @param array                                                   $p_configs
		 * @param \Symfony\Component\DependencyInjection\ContainerBuilder $p_container
		 */
		public function load( array $p_configs, ContainerBuilder $p_container )
		{
			$configuration = new Configuration ();
			$config        = $this->processConfiguration( $configuration, $p_configs );
			$loader        =
				new Loader\YamlFileLoader ( $p_container, new FileLocator ( __DIR__ . "/../Resources/config" ) );
			// ------------------------- DECLARE ---------------------------//

			$loader->load( "services.yml" );

			$this->loadResources( $p_container );
			$this->loadConfig( $p_container, $config );
		}

		/**
		 * Load resources.
		 * @param \Symfony\Component\DependencyInjection\ContainerBuilder $p_container
		 */
		private function loadResources( ContainerBuilder $p_container )
		{
			// ------------------------- DECLARE ---------------------------//

			$p_container->setParameter( "twig.form.resources", array_merge( array(
																				"KMSFroalaEditorBundle:Form:froala_widget.html.twig"
																			),
																			$p_container->getParameter( "twig.form.resources" ) ) );
		}

		/**
		 * Load config.
		 * @param \Symfony\Component\DependencyInjection\ContainerBuilder $p_container
		 * @param array                                                   $p_config
		 */
		private function loadConfig( ContainerBuilder $p_container, array $p_config )
		{
			$p_config [ "basePath" ] = ltrim( $p_config [ "basePath" ], '/' );
			// ------------------------- DECLARE ---------------------------//

			$p_container->setParameter( "kms_froala_editor.basePath", $p_config [ "basePath" ] );
			$p_container->setParameter( "kms_froala_editor.serialNumber", $p_config [ "serialNumber" ] );
			$p_container->setParameter( "kms_froala_editor.language", $p_config [ "language" ] );
			$p_container->setParameter( "kms_froala_editor.includeJQuery", $p_config [ "includeJQuery" ] );
			$p_container->setParameter( "kms_froala_editor.includeFontAwesome", $p_config [ "includeFontAwesome" ] );

			$p_container->setParameter( "kms_froala_editor.inlineMode", $p_config [ "inlineMode" ] );
			$p_container->setParameter( "kms_froala_editor.minHeight", $p_config [ "minHeight" ] );
			$p_container->setParameter( "kms_froala_editor.maxHeight", $p_config [ "maxHeight" ] );
			$p_container->setParameter( "kms_froala_editor.width", $p_config [ "width" ] );
			$p_container->setParameter( "kms_froala_editor.height", $p_config [ "height" ] );
			$p_container->setParameter( "kms_froala_editor.plainPaste", $p_config [ "plainPaste" ] );
			$p_container->setParameter( "kms_froala_editor.tabSpaces", $p_config [ "tabSpaces" ] );
			$p_container->setParameter( "kms_froala_editor.multiLine", $p_config [ "multiLine" ] );
			$p_container->setParameter( "kms_froala_editor.paragraphy", $p_config [ "paragraphy" ] );
			$p_container->setParameter( "kms_froala_editor.placeholder", $p_config [ "placeholder" ] );
			$p_container->setParameter( "kms_froala_editor.theme", $p_config [ "theme" ] );
			$p_container->setParameter( "kms_froala_editor.unlinkButton", $p_config [ "unlinkButton" ] );
			$p_container->setParameter( "kms_froala_editor.beautifyCode", $p_config [ "beautifyCode" ] );
			$array = isset ( $p_config [ "buttons" ] ) ? $p_config [ "buttons" ] : null;
			$p_container->setParameter( "kms_froala_editor.buttons", $array );
			$p_container->setParameter( "kms_froala_editor.convertMailAddresses",
										$p_config [ "convertMailAddresses" ] );

			// Load plugins.
			$this->loadPlugins( $p_container, $p_config );

			// Load image upload.
			$this->loadImageUpload( $p_container, $p_config );

			// Load media manager.
			$this->loadMediaManager( $p_container, $p_config );

			// Load auto save.
			$this->loadAutoSave( $p_container, $p_config );
		}

		/**
		 * Load plugins.
		 * @param \Symfony\Component\DependencyInjection\ContainerBuilder $p_container
		 * @param array                                                   $p_config
		 */
		private function loadPlugins( ContainerBuilder $p_container, array $p_config )
		{
			$pluginsNode = $p_config [ "plugins" ];
			// ------------------------- DECLARE ---------------------------//

			$p_container->setParameter( "kms_froala_editor.plugins.blockStyles", $pluginsNode [ "blockStyles" ] );
			$p_container->setParameter( "kms_froala_editor.plugins.colors", $pluginsNode [ "colors" ] );
			$p_container->setParameter( "kms_froala_editor.plugins.charCounter", $pluginsNode [ "charCounter" ] );
			$p_container->setParameter( "kms_froala_editor.plugins.fileUpload", $pluginsNode [ "fileUpload" ] );
			$p_container->setParameter( "kms_froala_editor.plugins.fontFamily", $pluginsNode [ "fontFamily" ] );
			$p_container->setParameter( "kms_froala_editor.plugins.fontSize", $pluginsNode [ "fontSize" ] );
			$p_container->setParameter( "kms_froala_editor.plugins.fullscreen", $pluginsNode [ "fullscreen" ] );
			$p_container->setParameter( "kms_froala_editor.plugins.lists", $pluginsNode [ "lists" ] );
			$p_container->setParameter( "kms_froala_editor.plugins.mediaManager", $pluginsNode [ "mediaManager" ] );
			$p_container->setParameter( "kms_froala_editor.plugins.tables", $pluginsNode [ "tables" ] );
			$p_container->setParameter( "kms_froala_editor.plugins.urls", $pluginsNode [ "urls" ] );
			$p_container->setParameter( "kms_froala_editor.plugins.video", $pluginsNode [ "video" ] );
		}

		/**
		 * Load image upload.
		 * @param \Symfony\Component\DependencyInjection\ContainerBuilder $p_container
		 * @param array                                                   $p_config
		 */
		private function loadImageUpload( ContainerBuilder $p_container, array $p_config )
		{
			$imageUploadNode = $p_config [ "imageUpload" ];
			// ------------------------- DECLARE ---------------------------//

			$p_container->setParameter( "kms_froala_editor.imageUpload.route", $imageUploadNode [ "route" ] );
			$p_container->setParameter( "kms_froala_editor.imageUpload.routeDelete",
										$imageUploadNode [ "routeDelete" ] );

			if( $imageUploadNode [ "path" ] != null )
			{
				$var = $imageUploadNode [ "path" ];
			}
			else
			{
				$var = $imageUploadNode [ "folder" ];
			}
			$p_container->setParameter( "kms_froala_editor.imageUpload.path", $var );

			$p_container->setParameter( "kms_froala_editor.imageUpload.folder", $imageUploadNode [ "folder" ] );
		}

		/**
		 * Load media manager.
		 * @param \Symfony\Component\DependencyInjection\ContainerBuilder $p_container
		 * @param array                                                   $p_config
		 */
		private function loadMediaManager( ContainerBuilder $p_container, array $p_config )
		{
			$mediaManagerNode = $p_config [ "mediaManager" ];
			// ------------------------- DECLARE ---------------------------//

			$p_container->setParameter( "kms_froala_editor.mediaManager.route", $mediaManagerNode [ "route" ] );
		}

		// -------------------------------------------------------------//
		// --------------------------- OVERRIDE ------------------------//
		// -------------------------------------------------------------//

		/**
		 * Load auto save.
		 * @param \Symfony\Component\DependencyInjection\ContainerBuilder $p_container
		 * @param array                                                   $p_config
		 */
		private function loadAutoSave( ContainerBuilder $p_container, array $p_config )
		{
			$autosaveNode = $p_config [ "autosave" ];
			// ------------------------- DECLARE ---------------------------//

			$p_container->setParameter( "kms_froala_editor.autosave.active", $autosaveNode [ "active" ] );
			$p_container->setParameter( "kms_froala_editor.autosave.interval", $autosaveNode [ "interval" ] );
			$p_container->setParameter( "kms_froala_editor.autosave.route", $autosaveNode [ "route" ] );
			$p_container->setParameter( "kms_froala_editor.autosave.requestType", $autosaveNode [ "requestType" ] );
			$array = isset ( $autosaveNode [ "params" ] ) ? $autosaveNode [ "params" ] : array();
			$p_container->setParameter( "kms_froala_editor.autosave.params", $array );
			$array = isset ( $autosaveNode [ "routeParams" ] ) ? $autosaveNode [ "routeParams" ] : array();
			$p_container->setParameter( "kms_froala_editor.autosave.routeParams", $array );
		}
	}
