<?php

namespace Almanac\Posts;

class Platform {

	const SONY_PS1 = 1;
	const SONY_PS2 = 2;
	const SONY_PS3 = 3;
	const SONY_PS4 = 4;
	const SONY_PSP = 5;
	const SONY_VITA = 6;

	const MS_XBOX = 7;
	const MS_XBOX360 = 8;
	const MS_XBOXONE = 9;

	const NINTENDO_NES = 10;
	const NINTENDO_SNES = 11;
	const NINTENDO_N64 = 12;
	const NINTENDO_GC = 13;
	const NINTENDO_WII = 14;
	const NINTENDO_WIIU = 15;
	const NINTENDO_SWITCH = 16;
	const NINTENDO_GB = 17;
	const NINTENDO_GBC = 18;
	const NINTENDO_GBA = 19;
	const NINTENDO_DS = 20;
	const NINTENDO_3DS = 21;

	const SEGA_MS = 22;
	const SEGA_MD = 23;
	const SEGA_SATURN = 24;
	const SEGA_DC = 25;
	const SEGA_GG = 26;

	const IOS = 27;
	const ANDROID = 28;

	const PC = 29;
	const MAC = 30;
	const LINUX = 31;

	const OTHER = 32;

	const NAMES = [
		self::SONY_PS1 => 'PS1',
		self::SONY_PS2 => 'PS2',
		self::SONY_PS3 => 'PS3',
		self::SONY_PS4 => 'PS4',
		self::SONY_PS5 => 'PS5',
		self::SONY_PSP => 'PSP',
		self::SONY_VITA => 'PSVita',
		self::MS_XBOX => 'Xbox',
		self::MS_XBOX360 => 'Xbox 360',
		self::MS_XBOXONE => 'Xbox One',
		self::NINTENDO_NES => 'NES',
		self::NINTENDO_SNES => 'SNES',
		self::NINTENDO_N64 => 'N64',
		self::NINTENDO_GC => 'GameCube',
		self::NINTENDO_WII => 'Wii',
		self::NINTENDO_WIIU => 'Wii U',
		self::NINTENDO_SWITCH => 'Switch',
		self::NINTENDO_GB => 'Game Boy',
		self::NINTENDO_GBC => 'Game Boy Color',
		self::NINTENDO_GBA => 'Game Boy Advance',
		self::NINTENDO_DS => 'DS',
		self::NINTENDO_3DS => '3DS',
		self::SEGA_MS => 'Master System',
		self::SEGA_MD => 'Mega Drive',
		self::SEGA_SATURN => 'Saturn',
		self::SEGA_DC => 'Dreamcast',
		self::SEGA_GG => 'Game Gear',
		self::IOS => 'iOS',
		self::ANDROID => 'Android',
		self::PC => 'PC',
		self::MAC => 'macOS',
		self::LINUX => 'Linux',
		self::OTHER => 'Other',
	];

}