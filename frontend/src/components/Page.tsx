// @flow 
import * as React from 'react';
import { Box, Container, makeStyles, Typography } from '@material-ui/core';

const useStyles = makeStyles({
    title: {
        color: '#99999999'
    }
})

type PageProps = {
    title: string
};
export const Page: React.FC<PageProps> = (props) => {
    const classes = useStyles();

    return (
        <Container maxWidth={'xl'}>
            <Typography className={classes.title} variant='h5'>
                {props.title}
            </Typography>
            <Box paddingTop={2}>
              {props.children}
            </Box>
        </Container>
    );
};