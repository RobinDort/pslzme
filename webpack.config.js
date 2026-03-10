const path = require("path");

module.exports = {
	mode: "development", // or 'development'
	entry: "./src/Resources/public/js/3D/pslzme3D.js",
	output: {
		filename: "pslzme-3d.bundle.js",
		path: path.resolve(__dirname, "./src/Resources/public/js/3D/bundles"), // output folder
	},
	module: {
		rules: [
			{
				test: /\.m?js$/,
				exclude: /(node_modules|bower_components)/,
				use: {
					loader: "babel-loader",
					options: {
						presets: ["@babel/preset-env"], // transpile modern JS
					},
				},
			},
		],
	},
	resolve: {
		alias: {
			three: path.resolve(__dirname, "node_modules/three"),
		},
	},
};
