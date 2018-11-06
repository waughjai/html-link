<?php

declare( strict_types = 1 );
namespace WaughJ\HTMLLink
{
	use WaughJ\HTMLAttributeList\HTMLAttributeList;
	use function \WaughJ\TestHashItem\TestHashItemBool;
	use function \WaughJ\TestHashItem\TestHashItemString;

	class HTMLLink
	{
		//
		//  PUBLIC
		//
		/////////////////////////////////////////////////////////

			public function __construct( string $href, $value, array $other_attributes = [], array $url_parameters = [] )
			{
				$this->href = TestHashItemString( $other_attributes, 'href', $href );
				$this->value = $value;
				$this->external = isset( $other_attributes[ 'external' ] ) && ( $other_attributes[ 'external' ] === true || $other_attributes[ 'external' ] === 'true' );
				$this->anchor = ( isset( $other_attributes[ 'anchor' ] ) ) ? $other_attributes[ 'anchor' ] : null;
				$other_attributes[ 'href' ] = $this->href . self::getParametersText( $url_parameters ) . self::getAnchorText( $this->anchor );
				$this->other_attributes = new HTMLAttributeList( $other_attributes, self::VALID_ATTRIBUTES );
				$this->url_parameters = $url_parameters;
			}

			public function __toString()
			{
				return $this->getHTML();
			}

			public function getURL() : string
			{
				return $this->getAttributeValue( 'href' );
			}

			public function getValue() : string
			{
				return $this->value;
			}

			public function getHTML() : string
			{
				return "<a{$this->other_attributes->getAttributesText()}{$this->getExternalAttributesTextIfExternal()}>" . ( string )( $this->value ) . "</a>";
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

			private static function getAnchorText( $anchor ) : string
			{
				return ( is_string( $anchor ) ) ? "#{$anchor}" : '';
			}

			private static function getParametersText( array $url_parameters ) : string
			{
				return ( empty( $url_parameters ) ) ? '' : '?' . self::implodeParameters( $url_parameters );
			}

			private static function implodeParameters( array $url_parameters ) : string
			{
				$text = '';
				foreach ( $url_parameters as $key => $value )
				{
					if ( is_string( ( string )( $value ) ) )
					{
						if ( $text !== '' )
						{
							$text .= '&';
						}
						$text .= "{$key}={$value}";
					}
				}
				return $text;
			}

			private $href;
			private $value;
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
				'type',
				'href'
			];
		}
}
