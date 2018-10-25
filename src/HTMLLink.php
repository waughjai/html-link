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

			public function __construct( string $href, $text, array $other_attributes = [] )
			{
				$this->href = $href;
				$this->text = $text;
				$this->external = TestHashItemBool( $other_attributes, 'external', false );
				$this->other_attributes = new HTMLAttributeList( $other_attributes, self::VALID_ATTRIBUTES );
			}

			public function __toString()
			{
				return $this->getHTML();
			}

			public function getURL() : string
			{
				return $this->href;
			}

			public function getText() : string
			{
				return $this->text;
			}

			public function getHTML() : string
			{
				return "<a href=\"{$this->href}\"{$this->other_attributes->getAttributesText()}{$this->getExternalAttributesTextIfExternal()}>{$this->text}</a>";
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

			private $href;
			private $text;
			private $external;
			private $other_attributes;

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
