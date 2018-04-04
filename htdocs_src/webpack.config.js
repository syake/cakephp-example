const ExtractTextPlugin = require('extract-text-webpack-plugin');

module.exports = (env, args) => [
  {
    // モード値を production に設定すると最適化された状態で、
    // development に設定するとソースマップ有効でJSファイルが出力される
    mode: 'development',
    
    // ビルドの対象となるディレクトリ
    context: __dirname + '/src/js',
    
    // メインとなるJavaScriptファイル（エントリーポイント）
    entry: {
      admin: './admin.js',
      app: './app.js'
    },
    
    // ファイルの出力設定
    output: {
      path: __dirname + '/../htdocs/js',
      filename: '[name].js'
    },
    
    // ビルドに必要なモジュール（loader）を指定
    module: {
      rules: [
        {
          // ビルドの対象ファイル
          test: /\.js$/,
          
          // ビルドから除外するディレクトリを指定
          exclude: /node_modules/,
          
          // ビルドで使用するloaderを指定
          use: [
            {
              // JavaScriptファイルを互換性のあるECMAScript 5に変換するモジュール
              loader: 'babel-loader',
              options: {
                presets: [
                  // env を指定することで、ES2017 を ES5 に変換。
                  // {modules: false}にしないと import 文が Babel によって CommonJS に変換され、
                  // webpack の Tree Shaking 機能が使えない
                  ['env', {'modules': false}]
                ]
              }
            }
          ]
        },
        {
          test: /\.vue$/,
          loader: 'vue-loader'
        },
        {
          test: /\.css$/, loader: 'style-loader!css-loader'
        },
        {
          test: /\.(otf|eot|svg|ttf|woff|woff2)(\?.+)?$/,
          loader: 'url-loader'
        }
      ]
    },
    resolve: {
      alias: {
        'vue$': 'vue/dist/vue.esm.js'
      }
    }
  },
  
  {
    mode: 'development',
    context: __dirname + '/src/sass',
    entry: {
      admin: './admin.scss',
      style: './style.scss'
    },
    output: {
      path: __dirname + '/../htdocs/css',
      filename: '[name].css'
    },
    module: {
      rules: [
        {
          test: /\.scss$/,
          exclude: /node_modules/,
          use: ExtractTextPlugin.extract({
            fallback: 'style-loader',
            use: [
              {
                loader: 'css-loader',
                options: {
                  // オプションでCSS内のurl()メソッドの取り込みを禁止する
                  url: false,
                  
                  // CSSの圧縮
                  minimize: (args.mode !== 'development'),
                  
                  // ソースマップの利用有無
                  sourceMap: (args.mode === 'development'),
                  
                  // 0 => no loaders (default);
                  // 1 => postcss-loader;
                  // 2 => postcss-loader, sass-loader
                  importLoaders: 2
                }
              },
              {
                loader: 'sass-loader',
                options: {
                  sourceMap: (args.mode === 'development')
                }
              }
            ]
          })
        }
      ]
    },
    plugins: [
      // ビルドされたjsファイルからstyleの部分を抽出してcssファイルで出力
      new ExtractTextPlugin('[name].css')
    ]
  }
];
