package io.nexin.cryptobonds.utils;

import android.app.Activity;
import android.content.Intent;
import android.support.v7.widget.Toolbar;
import android.view.View;

import com.mikepenz.materialdrawer.AccountHeader;
import com.mikepenz.materialdrawer.AccountHeaderBuilder;
import com.mikepenz.materialdrawer.Drawer;
import com.mikepenz.materialdrawer.DrawerBuilder;
import com.mikepenz.materialdrawer.model.PrimaryDrawerItem;
import com.mikepenz.materialdrawer.model.ProfileDrawerItem;
import com.mikepenz.materialdrawer.model.interfaces.IDrawerItem;
import com.mikepenz.materialdrawer.model.interfaces.IProfile;

import io.nexin.cryptobonds.R;
import io.nexin.cryptobonds.activities.MarketSpaceActivity;
import io.nexin.cryptobonds.activities.RequestsActivity;

public class MaterialDrawer {

    static Drawer result;


    public static void getDrawer(final Activity activity, Toolbar toolbar) {

        AccountHeader headerResult = new AccountHeaderBuilder()
                .withActivity(activity)
                .withHeaderBackground(R.color.primary)
                .addProfiles(
                        new ProfileDrawerItem().withName("Phone")
                                .withEmail("NID")
                )
                .withProfileImagesVisible(false)
                .withSelectionListEnabledForSingleProfile(false)
                .withOnAccountHeaderListener(new AccountHeader.OnAccountHeaderListener() {
                    @Override
                    public boolean onProfileChanged(View view, IProfile profile, boolean currentProfile) {
                        return false;
                    }
                })
                .build();

        PrimaryDrawerItem marketPlace = new PrimaryDrawerItem()
                .withIdentifier(1)
                .withName("Market place")
                .withTextColorRes(R.color.lightGrey)
                .withSelectedTextColorRes(R.color.white);

        PrimaryDrawerItem myRequest = new PrimaryDrawerItem()
                .withIdentifier(2)
                .withName("My Requests")
                .withTextColorRes(R.color.lightGrey)
                .withSelectedTextColorRes(R.color.white);

        result = new DrawerBuilder()
                .withActivity(activity)
                .withToolbar(toolbar)
                .withActionBarDrawerToggle(true)
                .withActionBarDrawerToggleAnimated(true)
                .withCloseOnClick(true)
                .withAccountHeader(headerResult)
                .withSelectedItem(-1)
                .withDrawerWidthDp(220)
                .addDrawerItems(
                        marketPlace,
                        myRequest
                )
                .withOnDrawerItemClickListener(new Drawer.OnDrawerItemClickListener() {
                    @Override
                    public boolean onItemClick(View view, int position, IDrawerItem drawerItem) {

                        switch (position) {
                            case 1:
                                result.closeDrawer();
                                result.deselect(1);
                                Intent intent1 = new Intent(activity, MarketSpaceActivity.class);
                                activity.startActivity(intent1);
                                break;
                            case 2:
                                result.closeDrawer();
                                result.deselect(2);
                                Intent intent2 = new Intent(activity, RequestsActivity.class);
                                activity.startActivity(intent2);
                                break;
                        }

                        return true;
                    }
                })
                .build();
    }

}
