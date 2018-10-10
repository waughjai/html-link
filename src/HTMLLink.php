<?php

declare( strict_types = 1 );
namespace WaughJ\HTMLLink
{
	use WaughJ\HTMLAttributeList\HTMLAttributeList;

	class HTMLLink
	{
		public function __construct( string $href, $title, array $other_attributes = [] )
		{
			$this->href = $href;
			$this->title = $title;
			$this->external = \WaughJ\TestHashItem\TestHashItemBool( $other_attributes, 'external', false );
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

		public function getTitle() : string
		{
			return $this->title;
		}

		public function getHTML() : string
		{
			return "<a href=\"{$this->href}\"{$this->other_attributes->getAttributesText()}{$this->getExternalAttributesTextIfExternal()}>{$this->title}</a>";
		}

		public function isExternal() : bool
		{
			return $this->external;
		}

		public function getAttributeValue( string $attribute_key ) : ?string
		{
			return $this->other_attributes->getAttributeValue( $attribute_key );
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
				$text .= ' rel="noopener noreferrer"';
			}
			return $text;
		}

		private $href;
		private $title;
		private $external;
		private $other_attributes;

		private const VALID_ATTRIBUTES =
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
