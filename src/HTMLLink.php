<?php

declare( strict_types = 1 );
namespace WaughJ\HTMLLink
{
	use WaughJ\HTMLAttributeList\HTMLAttributeList;
	use function \WaughJ\TestHashItem\TestHashItemBool;

	class HTMLLink
	{
		//
		//  PUBLIC
		//
		/////////////////////////////////////////////////////////

			public function __construct( string $href, $text, array $other_attributes = [], array $url_parameters = [] )
			{
				$this->href = $href;
				$this->text = $text;
				$this->external = TestHashItemBool( $other_attributes, 'external', false );
				$this->anchor = ( isset( $other_attributes[ 'anchor' ] ) ) ? $other_attributes[ 'anchor' ] : null;
				$this->other_attributes = new HTMLAttributeList( $other_attributes, self::VALID_ATTRIBUTES );
				$this->url_parameters = $url_parameters;
			}

			public function __toString()
			{
				return $this->getHTML();
			}

			public function getURL() : string
			{
				return $this->href . $this->getParametersText() . $this->getAnchorText();
			}

			public function getText() : string
			{
				return $this->text;
			}

			public function getHTML() : string
			{
				return "<a href=\"{$this->getURL()}\"{$this->other_attributes->getAttributesText()}{$this->getExternalAttributesTextIfExternal()}>{$this->text}</a>";
			}

			public function getAnchorText() : string
			{
				return ( $this->anchor ) ? "#{$this->anchor}" : '';
			}

			public function isExternal() : bool
			{
				return $this->external;
			}

			public function getAttributeValue( string $attribute_key )
			{
				return $this->other_attributes->getAttributeValue( $attribute_key );
			}



		//
		//  PRIVATE
		//
		/////////////////////////////////////////////////////////

			private function getParametersText() : string
			{
				return ( empty( $this->url_parameters ) ) ? '' : '?' . $this->implodeParameters();
			}

			private function implodeParameters() : string
			{
				$text = '';
				foreach ( $this->url_parameters as $key => $value )
				{
					if ( $text !== '' )
					{
						$text .= '&';
					}
					$text .= "{$key}={$value}";
				}
				return $text;
			}

			private function getExternalAttributesTextIfExternal() : string
			{
				return ( $this->external ) ? $this->getExternalAttributesText() : '';
			}

			private function getExternalAttributesText() : string
			{
				$text = '';
				if ( !$this->other_attributes->hasAttribute( 'target' ) )
				{
					$text .= ' target="_blank"';
				}
				if ( !$this->other_attributes->hasAttribute( 'rel' ) )
				{
					// Add this to prevent tabnapping.
					// See https://www.jitbit.com/alexblog/256-targetblank---the-most-underestimated-vulnerability-ever/
					$text .= ' rel="noopener noreferrer"';
				}
				return $text;
			}

			private $href;
			private $text;
			private $external;
			private $anchor;
			private $other_attributes;
			private $url_parameters;

			const VALID_ATTRIBUTES =
			[
				'class',
				'id',
				'title',
				'download',
				'hreflang',
				'ping',
				'referrerpolicy',
				'rel',
				'target',
				'type'
			];
		}
}
