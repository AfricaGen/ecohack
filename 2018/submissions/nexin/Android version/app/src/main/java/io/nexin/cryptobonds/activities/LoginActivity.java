package io.nexin.cryptobonds.activities;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.RelativeLayout;
import android.widget.Toast;

import com.android.volley.NetworkResponse;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.wang.avi.AVLoadingIndicatorView;

import org.json.JSONException;
import org.json.JSONObject;

import java.lang.reflect.Method;
import java.util.HashMap;
import java.util.Map;

import butterknife.BindView;
import butterknife.ButterKnife;
import io.nexin.cryptobonds.R;

public class LoginActivity extends AppCompatActivity {

    private Context context;

    @BindView(R.id.rootView) RelativeLayout rootView;
    @BindView(R.id.phone) EditText phone;
    @BindView(R.id.nid) EditText nid;
    @BindView(R.id.signUpBtn) Button signUpBtn;
    @BindView(R.id.avi) AVLoadingIndicatorView avi;

    private String phoneStr = "", nidStr = "";

    SharedPreferences acc_prefs, authPrefs;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        ButterKnife.bind(this);

        context = this;

        acc_prefs = getSharedPreferences("accPrefs", MODE_PRIVATE);
        authPrefs = getSharedPreferences("authPrefs", MODE_PRIVATE);

        signUpBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                checkInput();
            }
        });
    }

    public void setState(String state){
        if (state.equals("loading")){
            signUpBtn.setVisibility(View.INVISIBLE);
            avi.setVisibility(View.VISIBLE);
        }
        else {
            signUpBtn.setVisibility(View.VISIBLE);
            avi.setVisibility(View.INVISIBLE);
        }
    }

    public void checkInput(){
        setState("loading");
        phoneStr = phone.getText().toString();
        nidStr = nid.getText().toString();

        if (phoneStr.trim().isEmpty()){
            phone.setError("This field is required");
        }
        else if (nidStr.trim().isEmpty()){
            nid.setError("This field is required");
        }
        else {
            createAccount();
        }
    }

    public void createAccount(){

        String url = "http://6409be75.ngrok.io/register/";

        StringRequest stringRequest = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {

                Toast.makeText(context, response, Toast.LENGTH_LONG).show();
                try {
                    JSONObject jsonObject = new JSONObject(response);

                    String privateKey = jsonObject.getString("private_key");
                    String publicKey = jsonObject.getString("public_key");
                    String phone = jsonObject.getString("phone");
                    String nid = jsonObject.getString("id");

                    acc_prefs.edit()
                            .putString("private_key", privateKey)
                            .putString("public_key", publicKey)
                            .putString("phone", phone)
                            .putString("nid", nid)
                            .apply();

                    authPrefs.edit()
                            .putBoolean("is_logged_in", true)
                            .apply();

                    Intent intent = new Intent(context, MainActivity.class);
                    startActivity(intent);
                    finish();

                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                setState("idle");
                Snackbar.make(rootView, "Failed to create account", Snackbar.LENGTH_SHORT).show();
                NetworkResponse networkResponse = error.networkResponse;

                if (networkResponse != null){
                    Log.d("Error ", error.toString());
//                    Snackbar.make(rootView, String.valueOf(networkResponse.statusCode), Snackbar.LENGTH_INDEFINITE).show();
                }
            }
        }){
            @Override
            protected Map<String, String> getParams(){
                Map<String, String> params = new HashMap<>();

                params.put("phone", phoneStr);
                params.put("id", nidStr);

                return params;
            }
        };

        RequestQueue queue = Volley.newRequestQueue(context);
        queue.add(stringRequest);
    }
}
