const { readFileSync, writeFileSync } = require( 'node:fs' );
const path = require( 'node:path' );

const root = path.resolve( __dirname, '..' );
const manifest = JSON.parse( readFileSync( path.join( root, 'package.json' ), 'utf8' ) );

for ( const name of [ 'sass-basis', 'sass-basis-layout' ] ) {
	const filename = path.join( root, 'src/assets/packages', name, 'package.json' );
	const copied = JSON.parse( readFileSync( filename, 'utf8' ) );
	copied.engines = { ...copied.engines, ...manifest.engines };
	copied.volta = { ...copied.volta, node: manifest.volta.node };
	writeFileSync( filename, JSON.stringify( copied, null, 2 ) + '\n' );
}
