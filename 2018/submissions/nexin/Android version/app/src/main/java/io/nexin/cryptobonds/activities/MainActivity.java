package io.nexin.cryptobonds.activities;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.support.design.widget.FloatingActionButton;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.CardView;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.view.ViewGroup;
import android.widget.RelativeLayout;
import android.widget.TextView;

import butterknife.BindView;
import butterknife.ButterKnife;
import io.nexin.cryptobonds.R;
import io.nexin.cryptobonds.adapters.TransactionsAdapter;
import io.nexin.cryptobonds.utils.MaterialDrawer;

public class MainActivity extends AppCompatActivity {

    private Context context;

    @BindView(R.id.publicKey) TextView publicKey;
    @BindView(R.id.recyclerView) RecyclerView recyclerView;
    @BindView(R.id.toolbar) Toolbar toolbar;
    @BindView(R.id.sendBtn) FloatingActionButton sendBtn;
    @BindView(R.id.bondView) RelativeLayout bondView;
    @BindView(R.id.moneyView) RelativeLayout moneyView;
    @BindView(R.id.cardView) CardView cardView;

    SharedPreferences acc_prefs, authPrefs;

    private TransactionsAdapter transactionsAdapter;

    private AlertDialog alertDialog;
    private View alertDialogView;
    private AlertDialog.Builder alertDialogBuilder;
    FloatingActionButton okBtn, cancelBtn;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        ButterKnife.bind(this);

        context = this;
        MaterialDrawer.getDrawer(this, toolbar);

        acc_prefs = getSharedPreferences("accPrefs", MODE_PRIVATE);
        authPrefs = getSharedPreferences("authPrefs", MODE_PRIVATE);

        boolean isLoggedIn = authPrefs.getBoolean("is_logged_in", false);

//        if (!isLoggedIn){
//            Intent intent = new Intent(context, LoginActivity.class);
//            startActivity(intent);
//            finish();
//        }

//        publicKey.setText(acc_prefs.getString("public_key", ""));

        recyclerView.setHasFixedSize(true);
        LinearLayoutManager linearLayoutManager = new LinearLayoutManager(context);
        linearLayoutManager.setReverseLayout(true);
        linearLayoutManager.setStackFromEnd(true);
        recyclerView.setLayoutManager(linearLayoutManager);

        transactionsAdapter = new TransactionsAdapter(context);
        recyclerView.setAdapter(transactionsAdapter);

        alertDialogBuilder = new AlertDialog.Builder(context);
        alertDialogView = View.inflate(context,R.layout.send_bonds_dialog, null);
        cancelBtn = alertDialogView.findViewById(R.id.cancelBtn);
        okBtn = alertDialogView.findViewById(R.id.okBtn);
        alertDialogBuilder.setView(alertDialogView);

        cardView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(bondView.getVisibility() == View.VISIBLE){
                    bondView.setVisibility(View.INVISIBLE);
                    moneyView.setVisibility(View.VISIBLE);
                }
                else if (moneyView.getVisibility() == View.VISIBLE){
                    bondView.setVisibility(View.VISIBLE);
                    moneyView.setVisibility(View.INVISIBLE);
                }
            }
        });

        sendBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                alertDialog = alertDialogBuilder.create();
                alertDialog.show();
                alertDialog.setCanceledOnTouchOutside(false);
                alertDialog.setCancelable(false);
            }
        });

        cancelBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                alertDialog.dismiss();
                ((ViewGroup)alertDialogView.getParent()).removeView(alertDialogView);
            }
        });
    }
}
