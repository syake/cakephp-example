module.exports = {
  // モード値を production に設定すると最適化された状態で、
  // development に設定するとソースマップ有効でJSファイルが出力される
  mode: 'development',
  
  // ビルドの対象となるディレクトリ
  context: __dirname + '/src',
  
  // メインとなるJavaScriptファイル（エントリーポイント）
  entry: './js/index.js',
  
  // ファイルの出力設定
  output: {
    path: __dirname + '/dist',
    filename: 'app.js'
  }
}
