package br.com.retamero.ksoapnusoap;


import org.json.JSONException;
import org.json.JSONObject;
import org.ksoap2.SoapEnvelope;
import org.ksoap2.serialization.SoapObject;
import org.ksoap2.serialization.SoapSerializationEnvelope;
import org.ksoap2.transport.HttpTransportSE;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.app.Activity;

import static br.com.retamero.ksoapnusoap.R.id.button;


public class MainActivity extends Activity {
	/* Configurações que devem estar no lado WEBSERVICE do PHP/APACHE/WINDOWS ou LINUX
	 * mudar onde esta retamero.com.br pelo IP ou dominio da maquina que esta rodando o webservice.
	 */
	private static final String SOAP_ACTION = "http://retamero.com.br/webservice/server.php/exemplo";
	private static final String METHOD_NAME = "exemplo";
	private static final String NAMESPACE = "http://retamero.com.br/webservice";
	private static final String URL = "http://retamero.com.br/webservice/server.php?wsdl";
	private TextView tv, tv1, tv2, tv3, tv4, tv5, tv6, tv7, tv8, tv9, tv10, tv11, tv12, tv13, tv14, tv15, tv16;
	private EditText etTexto;
	private String response;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);
		tv = (TextView) findViewById(R.id.textView36); //retorno
		tv1 = (TextView) findViewById(R.id.textView4); //id
		tv2 = (TextView) findViewById(R.id.textView6); //peso
		tv3 = (TextView) findViewById(R.id.textView21); //altura
		tv4 = (TextView) findViewById(R.id.textView22); //pema
		tv5 = (TextView) findViewById(R.id.textView23); //peme
		tv6 = (TextView) findViewById(R.id.textView24); //quadril
		tv7 = (TextView) findViewById(R.id.textView25); //bies
		tv8 = (TextView) findViewById(R.id.textView26); //bidi
		tv9 = (TextView) findViewById(R.id.textView27); //tres
		tv10 = (TextView) findViewById(R.id.textView28); //trdi
		tv11 = (TextView) findViewById(R.id.textView29); //coes
		tv12 = (TextView) findViewById(R.id.textView30); //codi
		tv13 = (TextView) findViewById(R.id.textView31); //paes
		tv14 = (TextView) findViewById(R.id.textView32); //padi
		tv15 = (TextView) findViewById(R.id.textView33); //ques
		tv16 = (TextView) findViewById(R.id.textView34); //qudi
		etTexto = (EditText) findViewById(R.id.editText2);//envia
		Button btn = (Button) findViewById(button);
		btn.setOnClickListener(new View.OnClickListener() {
			public void onClick(View v) {
				String texto = etTexto.getText().toString();
				if(texto.equals("") || texto == null){ //tratamento de erro resposta nula
					tv.setText("ERR0: Um numero precisa ser especificado..");
				}else {
					Log.i("DEBUG", etTexto.getText().toString());
					myAsyncTask myRequest = new myAsyncTask();
					myRequest.execute();
				}
			}
		});

	}

	private class myAsyncTask extends AsyncTask<Void, Void, Void> {

		@Override
		protected void onPostExecute(Void result) {
			super.onPostExecute(result);
			try {
				JSONObject obj = new JSONObject(response);
				if(obj.getString("id").equals("vazio")){ //tratamento de erro resposta nula
					tv.setText("ERR0: Este usuario não existe em nosso banco de dados.");
				}else if(obj.getString("id").equals("null")){ //tratamento de erro resposta nula
					tv.setText("ERR0: Não foi possivel estabelecer uma conexão com o servidor.");
				}else{
					tv.setText(response);
				}
				tv1.setText(obj.getString("id"));
				tv2.setText(obj.getString("peso"));
				tv3.setText(obj.getString("altura"));
				tv4.setText(obj.getString("peitoral_maior"));
				tv5.setText(obj.getString("peitoral_menor"));
				tv6.setText(obj.getString("quadril"));
				tv7.setText(obj.getString("biceps_esquerdo"));
				tv8.setText(obj.getString("biceps_direito"));
				tv9.setText(obj.getString("triceps_esquerdo"));
				tv10.setText(obj.getString("triceps_direito"));
				tv11.setText(obj.getString("coxas_esquerda"));
				tv12.setText(obj.getString("coxas_direita"));
				tv13.setText(obj.getString("panturrilha_esquerda"));
				tv14.setText(obj.getString("panturrilha_direita"));
				tv15.setText(obj.getString("quadril_esquerdo"));
				tv16.setText(obj.getString("quadril_direito"));
			} catch (JSONException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}	
		}

		@Override
		protected void onPreExecute() {
			super.onPreExecute();
		}

		@Override
		protected Void doInBackground(Void... arg0) {
			SoapObject request = new SoapObject(NAMESPACE, METHOD_NAME);
			request.addProperty("id", etTexto.getText().toString());

			SoapSerializationEnvelope envelope = new SoapSerializationEnvelope(
					SoapEnvelope.VER11);
			envelope.dotNet = true;
			envelope.setOutputSoapObject(request);
			HttpTransportSE androidHttpTransport = new HttpTransportSE(URL);
			try {
				androidHttpTransport.call(SOAP_ACTION, envelope);
			} catch (Exception e) {
				e.printStackTrace();
			}

			SoapObject result;
			result = (SoapObject) envelope.bodyIn;

			if (result != null) {
				response = result.getProperty(0).toString();
				Log.i("TAG", response);

			} else {
				Log.i("App", "====> NULO <========");
				response = "{\"id\":\"null\"}";
			}

			return null;

		}
	}
}
