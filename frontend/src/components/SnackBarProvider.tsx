// @flow 
import { IconButton, makeStyles, Theme } from '@material-ui/core';
import { SnackbarProvider as NotistackProvider, SnackbarProviderProps } from 'notistack';
import * as React from 'react';
import CloseIcon from '@material-ui/icons/Close'

const useStyles = makeStyles((theme: Theme) => {
    return {
        variantSuccess: {
            backgroundColor: theme.palette.success.main
        },
        variantError: {
            backgroundColor: theme.palette.error.main
        },
        variantInfo: {
            backgroundColor: theme.palette.primary.main
        }
    }
})
export const SnackBarProvider: React.FC<SnackbarProviderProps> = (props) => {

    let snackbarProviderRef;
    const classes = useStyles();

    const defaultProps: SnackbarProviderProps = {
        children: props.children,
        classes,
        autoHideDuration: 3000,
        maxSnack: 3,
        anchorOrigin: {
            horizontal: 'right',
            vertical: 'top'
        },
        preventDuplicate: true,
        ref: (el) => snackbarProviderRef = el,
        action: (key) => (
            <IconButton 
                color={'inherit'} 
                style={{fontSize: 20}}
                onClick={() => snackbarProviderRef.closeSnackbar(key)}
            >
                <CloseIcon/>
            </IconButton>
        )
    };

    const newProps = { ...defaultProps, ...props};

    return (
        <NotistackProvider {...newProps}>
            {props.children}
        </NotistackProvider>
    );
};