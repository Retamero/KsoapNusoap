package br.com.retamero.ksoapnusoap;


import org.apache.http.entity.StringEntity;
import org.json.JSONException;
import org.json.JSONObject;
import org.ksoap2.SoapEnvelope;
import org.ksoap2.serialization.MarshalBase64;
import org.ksoap2.serialization.SoapObject;
import org.ksoap2.serialization.SoapSerializationEnvelope;
import org.ksoap2.transport.HttpTransportSE;
import android.content.Context;
import android.content.DialogInterface;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.app.Activity;
import android.widget.Toast;

import java.net.HttpURLConnection;

import static br.com.retamero.ksoapnusoap.R.id.button;
import static br.com.retamero.ksoapnusoap.R.id.button2;

public class MainActivity extends Activity {
	/* Configurações que devem estar no lado WEBSERVICE do PHP/APACHE/WINDOWS ou LINUX
	 * mudar onde esta retamero.com.br pelo IP ou dominio da maquina que esta rodando o webservice.
	 */
	private static final String SOAP_ACTION = "http://retamero.com.br/webservice/exemplo";
	private static final String SOAP_ACTION_UPDATE = "http://retamero.com.br/webservice/update";
	private static final String METHOD_NAME = "exemplo";
	private static final String METHOD_UPDATE = "update";
	private static final String NAMESPACE = "http://retamero.com.br/webservice";
	private static final String URL = "http://retamero.com.br/webservice/server.php?wsdl";
	private TextView tv, tv1, tv2, tv3, tv4, tv5, tv6, tv7, tv8, tv9, tv10, tv11, tv12, tv13, tv14, tv15, tv16;
	private EditText etTexto, ed1, ed2, ed3, ed4, ed5, ed6, ed7, ed8, ed9, ed10, ed11, ed12, ed13, ed14, ed15;
	private String response;
	private String msg, envia;

	public void limpaCampos(){
		tv1.setText("");
		tv2.setText("");
		tv3.setText("");
		tv4.setText("");
		tv5.setText("");
		tv6.setText("");
		tv7.setText("");
		tv8.setText("");
		tv9.setText("");
		tv10.setText("");
		tv11.setText("");
		tv12.setText("");
		tv13.setText("");
		tv14.setText("");
		tv15.setText("");
		tv16.setText("");
	}

	public void notifica(String msg){
		Context contexto = getApplicationContext();
		int duracao = Toast.LENGTH_LONG;
		Toast toast = Toast.makeText(contexto, msg, duracao);
		toast.show();
	}

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		msg ="Digite o ID do aluno.";
		notifica(msg);
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
		ed1 = (EditText) findViewById(R.id.editText3); //peso
		ed2 = (EditText) findViewById(R.id.editText4); //altura
		ed3 = (EditText) findViewById(R.id.editText5); //pema
		ed4 = (EditText) findViewById(R.id.editText6); //peme
		ed5 = (EditText) findViewById(R.id.editText7); //quadril
		ed6 = (EditText) findViewById(R.id.editText8); //bies
		ed7 = (EditText) findViewById(R.id.editText9); //bidi
		ed8 = (EditText) findViewById(R.id.editText10); //tres
		ed9 = (EditText) findViewById(R.id.editText11);  //trdi
		ed10 = (EditText) findViewById(R.id.editText12); //coes
		ed11 = (EditText) findViewById(R.id.editText13); //codi
		ed12 = (EditText) findViewById(R.id.editText14); //paes
		ed13 = (EditText) findViewById(R.id.editText15); //padi
		ed14 = (EditText) findViewById(R.id.editText16); //ques
		ed15 = (EditText) findViewById(R.id.editText17); //qudi

		Button btnEnviar = (Button) findViewById(button);
		Button btnEditar = (Button) findViewById(button2);
		btnEnviar.setOnClickListener(new View.OnClickListener() {
			public void onClick(View v) {
				limpaCampos();
				String texto = etTexto.getText().toString();
				if(texto.equals("") || texto == null){ //tratamento de erro iserção vazia
					msg = "ERR0: Um numero precisa ser especificado..";
					tv.setText(msg);
					notifica(msg);
				}else {
					myAsyncTask myRequest = new myAsyncTask();
					myRequest.execute();
				}
			}
		});

		btnEditar.setOnClickListener(new View.OnClickListener() {
			public void onClick(View v) {
				limpaCampos();
				String texto = etTexto.getText().toString();
				if(texto.equals("") || texto == null){ //tratamento de erro iserção vazia
					msg = "ERR0: Um numero precisa ser especificado..";
					tv.setText(msg);
					notifica(msg);
				}else {
					editarAsynTask myRequestEditar = new editarAsynTask();
					myRequestEditar.execute();
					msg = "Informações alteradas com sucesso!";
					tv.setText(msg);
					notifica(msg);
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
				if(obj.getString("id").equals("vazio")){ //tratamento de erro usuario não encontrado
					msg = "Este usuario não existe em nosso banco de dados.";
					tv.setText(msg);
					notifica(msg);
				}else if(obj.getString("id").equals("null")){ //tratamento de erro resposta nula
					msg = "Não foi possivel estabelecer uma conexão com o servidor.";
					tv.setText(msg);
					notifica(msg);
				}else{
					tv.setText(response);
					msg = "Busca realizada com sucesso!";
					tv.setText(response);
					notifica(msg);
				}
				if(response.equals("{\"id\":\"null\"}") || response.equals("{\"id\":\"vazio\"}")){
					tv1.setText("");
				}else{
					tv1.setText(obj.getString("id"));
				}
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
				ed1.setText(obj.getString("peso"));
				ed2.setText(obj.getString("altura"));
				ed3.setText(obj.getString("peitoral_maior"));
				ed4.setText(obj.getString("peitoral_menor"));
				ed5.setText(obj.getString("quadril"));
				ed6.setText(obj.getString("biceps_esquerdo"));
				ed7.setText(obj.getString("biceps_direito"));
				ed8.setText(obj.getString("triceps_esquerdo"));
				ed9.setText(obj.getString("triceps_direito"));
				ed10.setText(obj.getString("coxas_esquerda"));
				ed11.setText(obj.getString("coxas_direita"));
				ed12.setText(obj.getString("panturrilha_esquerda"));
				ed13.setText(obj.getString("panturrilha_direita"));
				ed14.setText(obj.getString("quadril_esquerdo"));
				ed15.setText(obj.getString("quadril_direito"));
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
				Log.i("SELECT", response);

			} else {
				Log.i("SELECT", "====> NULO <========");
				response = "{\"id\":\"null\"}";
			}
			return null;
		}
	}

	private class editarAsynTask extends AsyncTask<Void, Void, Void> {
		@Override
		protected void onPostExecute(Void result) {
			super.onPostExecute(result);
			try {
				JSONObject objReceive = new JSONObject(response);
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
				JSONObject objSend = new JSONObject();
			try {
				objSend.accumulate("peso", ed1.getText().toString());
				objSend.accumulate("altura", ed2.getText().toString());
				objSend.accumulate("peitoral_maior", ed3.getText().toString());
				objSend.accumulate("peitoral_menor", ed4.getText().toString());
				objSend.accumulate("quadril", ed5.getText().toString());
				objSend.accumulate("biceps_esquerdo", ed6.getText().toString());
				objSend.accumulate("biceps_direito", ed7.getText().toString());
				objSend.accumulate("triceps_esquerdo", ed8.getText().toString());
				objSend.accumulate("triceps_direito", ed9.getText().toString());
				objSend.accumulate("coxas_esquerda", ed10.getText().toString());
				objSend.accumulate("coxas_direita", ed11.getText().toString());
				objSend.accumulate("panturrilha_esquerda", ed12.getText().toString());
				objSend.accumulate("panturrilha_direita", ed13.getText().toString());
				objSend.accumulate("quadril_esquerdo", ed14.getText().toString());
				objSend.accumulate("quadril_direito", ed15.getText().toString());
				} catch (JSONException e) {
					e.printStackTrace();
				}
				SoapObject request = new SoapObject(NAMESPACE,METHOD_UPDATE);
				request.addProperty("id", etTexto.getText().toString());
			request.addProperty("json", objSend.toString());

				Log.i("DEBUG", "ENVIA " + objSend.toString());
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
				Log.i("UPDATE", response);
				} else {
				Log.i("SELECT", "====> NULO <========");
				response = "{\"id\":\"null\"}";
			}
			return null;
		}

	}
}
