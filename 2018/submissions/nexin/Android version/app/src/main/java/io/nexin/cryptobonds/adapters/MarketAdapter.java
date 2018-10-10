package io.nexin.cryptobonds.adapters;

import android.content.Context;
import android.support.annotation.NonNull;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import io.nexin.cryptobonds.R;

public class MarketAdapter extends RecyclerView.Adapter<MarketAdapter.ViewHolder> {

    private Context context;

    public MarketAdapter(Context context) {
        this.context = context;
    }

    @NonNull
    @Override
    public MarketAdapter.ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int i) {
        View v = LayoutInflater.from(parent.getContext()).inflate(R.layout.market_place_item, parent, false);

        return new ViewHolder(v);
    }

    @Override
    public void onBindViewHolder(@NonNull MarketAdapter.ViewHolder viewHolder, int i) {

    }

    @Override
    public int getItemCount() {
        return 1;
    }

    public class ViewHolder extends RecyclerView.ViewHolder{

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
        }
    }
}
