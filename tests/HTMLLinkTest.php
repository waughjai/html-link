<?php

use PHPUnit\Framework\TestCase;
use WaughJ\HTMLLink\HTMLLink;

class HTMLLinkTest extends TestCase
{
	public function testLinkURL() : void
	{
		$link = $this->getDemoLink();
		$this->assertEquals( $link->getURL(), self::DEMO_URL );
	}

	public function testLinkText() : void
	{
		$link = $this->getDemoLink();
		$this->assertEquals( $link->getText(), self::DEMO_TEXT );
	}

	public function testLinkHTML() : void
	{
		$link = $this->getDemoLink();
		$this->assertEquals( $link->getHTML(), '<a href="' . self::DEMO_URL . '">' . self::DEMO_TEXT . '</a>' );
	}

	public function testLinkAsString() : void
	{
		$link = $this->getDemoLink();
		$this->assertEquals( ( string )( $link ), '<a href="' . self::DEMO_URL . '">' . self::DEMO_TEXT . '</a>' );
	}

	public function testExternalLink() : void
	{
		$local_link = $this->getDemoLink();
		$external_link = new HTMLLink( self::DEMO_URL, self::DEMO_TEXT, [ 'external' => true ] );
		$this->assertEquals( $local_link->isExternal(), false );
		$this->assertEquals( $external_link->isExternal(), true );
	}

	public function testExternalLinkHTML() : void
	{
		$link = new HTMLLink( self::DEMO_URL, self::DEMO_TEXT, [ 'external' => true ] );
		$this->assertEquals( $link->getHTML(), '<a href="' . self::DEMO_URL . '" target="_blank" rel="noopener noreferrer">' . self::DEMO_TEXT . '</a>' );
	}

	public function testExternalLinkOverrideHTML() : void
	{
		$link = new HTMLLink( self::DEMO_URL, self::DEMO_TEXT, [ 'external' => true, 'target' => '_new' ] );
		$this->assertEquals( $link->getHTML(), '<a href="' . self::DEMO_URL . '" target="_new" rel="noopener noreferrer">' . self::DEMO_TEXT . '</a>' );
	}

	public function testLinkWithExtraAttributes() : void
	{
		$link = new HTMLLink( self::DEMO_URL, self::DEMO_TEXT, [ 'class' => 'link', 'id' => 'link', 'title' => 'Google' ] );
		$this->assertEquals( $link->getHTML(), '<a href="' . self::DEMO_URL . '" class="link" id="link" title="Google">' . self::DEMO_TEXT . '</a>' );
	}

	public function testInvalidAttributes() : void
	{
		$link = new HTMLLink( self::DEMO_URL, self::DEMO_TEXT, [ 'class' => 'link', 'id' => 'link', 'weapon' => 'club', 'animal' => 'cat' ] );
		$this->assertEquals( $link->getHTML(), '<a href="' . self::DEMO_URL . '" class="link" id="link">' . self::DEMO_TEXT . '</a>' );
	}

	public function testGetAttribute() : void
	{
		$link = new HTMLLink( self::DEMO_URL, self::DEMO_TEXT, [ 'class' => 'link', 'id' => 'link', 'title' => 'Google' ] );
		$this->assertEquals( $link->getAttributeValue( 'class' ), 'link' );
		$this->assertEquals( $link->getAttributeValue( 'food' ), null );
	}

	public function testAnchorLink() : void
	{
		$link = new HTMLLink( self::DEMO_URL, self::DEMO_TEXT, [ 'anchor' => 'top' ] );
		$this->assertEquals( $link->getHTML(), '<a href="' . self::DEMO_URL . '#top">' . self::DEMO_TEXT . '</a>' );
	}

	private function getDemoLink() : HTMLLink
	{
		return new HTMLLink( self::DEMO_URL, self::DEMO_TEXT );
	}

	private const DEMO_TEXT = 'Google';
	private const DEMO_URL   = 'https://www.google.com';
}
