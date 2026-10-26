const assert = require( 'node:assert/strict' );
const { readFileSync, readdirSync } = require( 'node:fs' );
const path = require( 'node:path' );
const test = require( 'node:test' );

const root = path.resolve( __dirname, '../..' );
const readJSON = ( filename ) => JSON.parse( readFileSync( filename, 'utf8' ) );

function files( directory ) {
	return readdirSync( directory, { withFileTypes: true } ).flatMap( ( entry ) => {
		if ( entry.name === 'node_modules' || entry.name.startsWith( '.' ) ) {
			return [];
		}
		return entry.isDirectory()
			? files( path.join( directory, entry.name ) ).map( ( name ) => path.join( entry.name, name ) )
			: [ entry.name ];
	} ).sort();
}

for ( const name of [ 'sass-basis', 'sass-basis-layout' ] ) {
	test( `build preserves ${ name } assets and package metadata`, () => {
		const source = path.join( root, 'node_modules', name );
		const target = path.join( root, 'src/assets/packages', name );
		assert.deepEqual( files( target ), files( source ) );
		for ( const filename of files( source ).filter( ( file ) => file !== 'package.json' ) ) {
			assert.deepEqual(
				readFileSync( path.join( target, filename ) ),
				readFileSync( path.join( source, filename ) ),
				filename
			);
		}

		const manifest = readJSON( path.join( root, 'package.json' ) );
		const original = readJSON( path.join( source, 'package.json' ) );
		const copied = readJSON( path.join( target, 'package.json' ) );
		assert.deepEqual( copied, {
			...original,
			engines: { ...original.engines, ...manifest.engines },
			volta: { ...original.volta, node: manifest.volta.node },
		} );
	} );
}
