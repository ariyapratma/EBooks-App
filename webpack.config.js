const path = require("path");

module.exports = {
    entry: "./resources/js/pdf-viewer.js",
    output: {
        filename: "pdf-viewer.js",
        path: path.resolve(__dirname, "public/js"),
    },
    mode: "development", // Ubah ke 'production' untuk build final
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: "babel-loader",
                    options: {
                        presets: ["@babel/preset-env"],
                    },
                },
            },
        ],
    },
};
